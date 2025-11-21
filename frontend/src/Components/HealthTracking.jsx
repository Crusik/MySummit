import React, { useEffect, useRef, useState } from 'react';
import { Chart } from 'chart.js/auto';
import { FaLungs } from 'react-icons/fa';
import { FaTemperatureHigh } from 'react-icons/fa6';
import { FaHeartPulse } from 'react-icons/fa6';
import './HealthTracking.css';

function HealthTracking({ token }) {
  const chartRef = useRef(null);
  const chartInstance = useRef(null);
  const [healthData, setHealthData] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!token) return;

    fetch('http://localhost:8000/api/health', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
      .then((res) => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
      })
      .then((data) => {
        console.log('Health data from API:', data);
        setHealthData(data);
      })
      .catch((err) => {
        console.error('Failed to load health data', err);
        setLoading(false);
      });
  }, [token]);

  useEffect(() => {
    if (!healthData || !healthData.diagnosis_history) {
      setLoading(false);
      return;
    }

    if (chartInstance.current) {
      chartInstance.current.destroy();
    }

    const ctx = chartRef.current.getContext('2d');
    const lastSix = healthData.diagnosis_history.slice(-6);
    const labels = lastSix.map((d) => `${d.month} ${d.year}`);
    const systolicData = lastSix.map((d) => d.blood_pressure.systolic.value);
    const diastolicData = lastSix.map((d) => d.blood_pressure.diastolic.value);

    chartInstance.current = new Chart(ctx, {
      type: 'line',
      data: {
        labels,
        datasets: [
          {
            label: 'Systolic',
            data: systolicData,
            borderColor: '#667eea',
            borderWidth: 3,
            fill: false,
            tension: 0.5,
            pointBackgroundColor: '#667eea',
            pointBorderColor: '#FFFFFF',
            pointBorderWidth: 1,
            pointRadius: 6,
          },
          {
            label: 'Diastolic',
            data: diastolicData,
            borderColor: '#764ba2',
            borderWidth: 3,
            fill: false,
            tension: 0.5,
            pointBackgroundColor: '#764ba2',
            pointBorderColor: '#FFFFFF',
            pointBorderWidth: 1,
            pointRadius: 6,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        scales: {
          x: {
            grid: {
              display: false,
            },
          },
          y: {
            beginAtZero: false,
            max: 140,
            grid: {
              lineWidth: 2,
            },
            ticks: {
              stepSize: 20,
            },
          },
        },
      },
    });

    setLoading(false);
  }, [healthData]);

  if (loading || !healthData || !healthData.diagnosis_history) {
    return (
      <div className='health-tracking-section'>
        <h3 className='Card-Headers'>Health Tracking</h3>
        <div className='health-history-section'>
          <div className='health-history-top'>
            <div className='chart-section'>
              <div className='diagnosis-header'>
                <h4>Blood Pressure</h4>
                <span>No data available</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }

  const latest = healthData.diagnosis_history.slice(-1)[0];

  return (
    <div className='health-tracking-section'>
      <h3 className='Card-Headers'>Health Tracking</h3>
      <div className='health-history-section'>
        <div className='health-history-top'>
          <div className='chart-section'>
            <div className='diagnosis-header'>
              <h4>Blood Pressure</h4>
              <span>Last 6 months</span>
            </div>
            <div className='diagnosis-chart'>
              <canvas ref={chartRef} />
            </div>
          </div>
          <div className='recent'>
            <div className='systolic'>
              <div className='systolic-header'>
                <span className='blue-dot'></span>
                <span>Systolic</span>
              </div>
              <span className='recent-reading'>
                {latest.blood_pressure.systolic.value}
              </span>
              <div className='average'>
                <span>{latest.blood_pressure.systolic.levels}</span>
              </div>
            </div>
            <div className='diastolic'>
              <div className='diastolic-header'>
                <span className='purple-dot'></span>
                <span>Diastolic</span>
              </div>
              <span className='recent-reading'>
                {latest.blood_pressure.diastolic.value}
              </span>
              <div className='average'>
                <span>{latest.blood_pressure.diastolic.levels}</span>
              </div>
            </div>
          </div>
        </div>
        <div className='health-history-bottom'>
          <div className='respiratory-rate'>
            <div className='icon-wrapper'>
              <FaLungs className='icon' />
            </div>
            <div className='card-header'>Respiratory Rate</div>
            <div className='card-reading'>
              {latest.respiratory_rate.value} bpm
            </div>
            <div className='card-status'>{latest.respiratory_rate.levels}</div>
          </div>
          <div className='temperature'>
            <div className='icon-wrapper'>
              <FaTemperatureHigh className='icon' />
            </div>
            <div className='card-header'>Temperature</div>
            <div className='card-reading'>{latest.temperature.value}°F</div>
            <div className='card-status'>{latest.temperature.levels}</div>
          </div>
          <div className='heart-rate'>
            <div className='icon-wrapper'>
              <FaHeartPulse className='icon' />
            </div>
            <div className='card-header'>Heart Rate</div>
            <div className='card-reading'>{latest.heart_rate.value} bpm</div>
            <div className='card-status'>
              <div>{latest.heart_rate.levels}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default HealthTracking;
