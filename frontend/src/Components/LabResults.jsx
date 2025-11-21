import React, { useState, useEffect } from 'react';
import {
  FaDroplet,
  FaImage,
  FaCircleCheck,
  FaChevronDown,
  FaChevronRight,
} from 'react-icons/fa6';
import './LabResults.css';

function LabResults({ token }) {
  const [labResults, setLabResults] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [expandedId, setExpandedId] = useState(null);
  const [filterStatus, setFilterStatus] = useState('all');

  useEffect(() => {
    setLoading(true);
    setError(null);
    fetch('http://localhost:8000/api/lab-results', {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      },
    })
      .then((res) => {
        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
        return res.json();
      })
      .then((data) => {
        setLabResults(data);
        setLoading(false);
      })
      .catch((err) => {
        console.error('Error fetching lab results:', err);
        setError(err.message);
        setLoading(false);
      });
  }, [token]);

  const getStatusBadge = (status) => {
    const statusMap = {
      pending: { bg: 'bg-warning', text: 'Pending' },
      completed: { bg: 'bg-info', text: 'Completed' },
      reviewed: { bg: 'bg-success', text: 'Reviewed' },
    };
    const config = statusMap[status] || { bg: 'bg-secondary', text: status };
    return <span className={`badge ${config.bg}`}>{config.text}</span>;
  };

  const getTypeIcon = (testType) => {
    const iconMap = {
      blood_work: <FaDroplet className='test-type-icon blood-work' />,
      imaging: <FaImage className='test-type-icon imaging' />,
      screening: <FaCircleCheck className='test-type-icon screening' />,
    };
    return iconMap[testType] || <FaCircleCheck className='test-type-icon' />;
  };

  const filteredResults = labResults.filter(
    (result) => filterStatus === 'all' || result.status === filterStatus,
  );

  if (loading) {
    return (
      <div className='lab-results-container'>
        <div className='text-center py-4'>Loading lab results...</div>
      </div>
    );
  }

  if (error) {
    return (
      <div className='lab-results-container'>
        <div className='alert alert-danger' role='alert'>
          Error loading lab results: {error}
        </div>
      </div>
    );
  }

  return (
    <div className='lab-results-container'>
      <h2 className='lab-results-title'>Lab Results</h2>

      {/* Filter Tabs */}
      <div className='lab-results-filters mb-4'>
        {['all', 'pending', 'completed', 'reviewed'].map((status) => (
          <button
            key={status}
            className={`filter-btn ${filterStatus === status ? 'active' : ''}`}
            onClick={() => setFilterStatus(status)}
          >
            {status.charAt(0).toUpperCase() + status.slice(1)}
            <span className='count'>
              {status === 'all'
                ? labResults.length
                : labResults.filter((r) => r.status === status).length}
            </span>
          </button>
        ))}
      </div>

      {/* Results List */}
      <div className='lab-results-list'>
        {filteredResults.length === 0 ? (
          <div className='empty-state'>
            <p>No lab results found</p>
          </div>
        ) : (
          filteredResults.map((result) => (
            <div key={result.id} className='lab-result-card'>
              <div className='result-header'>
                <div className='result-title-section'>
                  <span className='type-icon'>
                    {getTypeIcon(result.test_type)}
                  </span>
                  <div>
                    <h3 className='result-test-name'>{result.test_name}</h3>
                    <p className='result-date'>
                      {new Date(result.test_date).toLocaleDateString()}
                    </p>
                  </div>
                </div>
                <div className='result-status'>
                  {getStatusBadge(result.status)}
                </div>
              </div>

              {result.description && (
                <p className='result-description'>{result.description}</p>
              )}

              <button
                className='expand-btn'
                onClick={() =>
                  setExpandedId(expandedId === result.id ? null : result.id)
                }
              >
                {expandedId === result.id ? (
                  <>
                    <FaChevronDown className='expand-icon' />
                    Hide Details
                  </>
                ) : (
                  <>
                    <FaChevronRight className='expand-icon' />
                    Show Details
                  </>
                )}
              </button>

              {expandedId === result.id && (
                <div className='result-details'>
                  <div className='detail-row'>
                    <span className='detail-label'>Test Type:</span>
                    <span className='detail-value'>
                      {result.test_type.replace('_', ' ').toUpperCase()}
                    </span>
                  </div>

                  {result.result_value && (
                    <div className='detail-row'>
                      <span className='detail-label'>Result:</span>
                      <span className='detail-value'>
                        {result.result_value}
                      </span>
                    </div>
                  )}

                  {result.unit && (
                    <div className='detail-row'>
                      <span className='detail-label'>Unit:</span>
                      <span className='detail-value'>{result.unit}</span>
                    </div>
                  )}

                  {result.reference_range && (
                    <div className='detail-row'>
                      <span className='detail-label'>Reference Range:</span>
                      <span className='detail-value'>
                        {result.reference_range}
                      </span>
                    </div>
                  )}

                  {result.results_received_date && (
                    <div className='detail-row'>
                      <span className='detail-label'>Results Received:</span>
                      <span className='detail-value'>
                        {new Date(
                          result.results_received_date,
                        ).toLocaleDateString()}
                      </span>
                    </div>
                  )}

                  {result.provider_notes && (
                    <div className='detail-row notes'>
                      <span className='detail-label'>Provider Notes:</span>
                      <p className='provider-notes'>{result.provider_notes}</p>
                    </div>
                  )}
                </div>
              )}
            </div>
          ))
        )}
      </div>
    </div>
  );
}

export default LabResults;
