// src/Components/MyCalendar.jsx
import React, { useState, useEffect } from 'react';
import { Calendar, momentLocalizer, Views } from 'react-big-calendar';
import { Modal, Button } from 'react-bootstrap';
import moment from 'moment';
import 'react-big-calendar/lib/css/react-big-calendar.css'; // make sure this is loaded
import './MyCalendar.css';

const localizer = momentLocalizer(moment);

function MyCalendar({ token }) {
  const [events, setEvents] = useState([]);

  // State for Bootstrap modal showing event details
  const [selectedEvent, setSelectedEvent] = useState(null);
  const [showModal, setShowModal] = useState(false);

  useEffect(() => {
    // Only fetch events if the user is authenticated (has a token)
    if (!token) return;

    // Fetch events from the Laravel backend API
    fetch('http://localhost:8000/api/events', {
      headers: {
        // Include the bearer token for authentication
        Authorization: `Bearer ${token}`,
      },
    })
      .then((res) => {
        // Check if the HTTP response was successful (status 200-299)
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        // Parse the JSON response body
        return res.json();
      })
      .then((data) => {
        // Log raw data from API for debugging
        console.log('RAW events from API:', data);

        // Transform each event object to format it for react-big-calendar
        const formatted = data
          .map((evt) => {
            // Try multiple possible field names for start time
            // Backend uses 'start_time', but code handles alternatives for flexibility
            const startVal =
              evt.start ?? evt.start_time ?? evt.starts_at ?? evt.startDate;
            // Try multiple possible field names for end time
            const endVal =
              evt.end ?? evt.end_time ?? evt.ends_at ?? evt.endDate;

            // Return event with converted Date objects (required by react-big-calendar)
            return {
              ...evt,
              // Convert ISO date string to JavaScript Date object for calendar
              start: startVal ? new Date(startVal) : null,
              end: endVal ? new Date(endVal) : null,
            };
          })
          // Filter out events that don't have valid start or end times
          .filter((evt) => evt.start && evt.end);

        // Log formatted data for debugging
        console.log('Formatted events for calendar:', formatted);
        // Update component state with formatted events to trigger re-render
        setEvents(formatted);
      })
      .catch((err) => {
        // Log any errors that occur during fetch or data processing
        console.error('Failed to load events', err);
      });
  }, [token]);

  // Handle event click - display modal with event details
  const handleSelectEvent = (event) => {
    setSelectedEvent(event);
    setShowModal(true);
  };

  // Close modal
  const handleCloseModal = () => {
    setShowModal(false);
    setSelectedEvent(null);
  };

  return (
    <div className='calendar-card-wrapper'>
      <div className='card shadow border-0'>
        <div className='card-header bg-primary text-white d-flex justify-content-between align-items-center'>
          <span>Appointment Schedule</span>
          <span className='badge bg-light text-primary'>MySummit</span>
        </div>

        <div className='card-body d-flex justify-content-center'>
          <div className='calendar-wrapper flex-grow-1'>
            <Calendar
              localizer={localizer}
              events={events}
              startAccessor='start'
              endAccessor='end'
              style={{ height: 700 }}
              selectable={false}
              resizable={false}
              popup={true}
              onSelectEvent={handleSelectEvent}
              // Prevent selecting empty slots
              onSelectSlot={() => {}}
              onSelecting={() => false}
            />
          </div>
        </div>

        <div className='card-footer text-center text-muted small'>
          Click on a date to view an appointment
        </div>
      </div>

      {/* Modal displaying event details */}
      <Modal show={showModal} onHide={handleCloseModal} centered>
        <Modal.Header closeButton>
          <Modal.Title>Appointment Details</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          {selectedEvent && (
            <div>
              <p>
                <strong>Title:</strong> {selectedEvent.title}
              </p>
              <p>
                <strong>Date:</strong>{' '}
                {selectedEvent.start?.toLocaleDateString()}
              </p>
              <p>
                <strong>Time:</strong>{' '}
                {selectedEvent.start?.toLocaleTimeString([], {
                  hour: '2-digit',
                  minute: '2-digit',
                })}{' '}
                -{' '}
                {selectedEvent.end?.toLocaleTimeString([], {
                  hour: '2-digit',
                  minute: '2-digit',
                })}
              </p>
              {selectedEvent.description && (
                <p>
                  <strong>Description:</strong> {selectedEvent.description}
                </p>
              )}
            </div>
          )}
        </Modal.Body>
        <Modal.Footer>
          <Button variant='secondary' onClick={handleCloseModal}>
            Close
          </Button>
        </Modal.Footer>
      </Modal>
    </div>
  );
}

export default MyCalendar;
