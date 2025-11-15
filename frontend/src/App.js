import React, { useState, useEffect } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import { Container, Tabs, Tab, Button } from 'react-bootstrap';

// Import your section components
import Nav from './Components/Nav';
import HealthTracking from './Components/HealthTracking';
import LabResults from './Components/LabResults';
import MyCalendar from './Components/MyCalendar';
import MessagingSystem from './Components/MessagingSystem';
import Payments from './Components/Payments';
import Login from './Components/Login';
import './App.css';

function App() {
  const [authToken, setAuthToken] = useState(localStorage.getItem('authToken'));
  const [user, setUser] = useState(
    localStorage.getItem('user')
      ? JSON.parse(localStorage.getItem('user'))
      : null,
  );

  useEffect(() => {
    // Check if token exists on mount
    const token = localStorage.getItem('authToken');
    if (token) {
      setAuthToken(token);
    }
  }, []);

  const handleLoginSuccess = (token, userData) => {
    setAuthToken(token);
    setUser(userData);
    localStorage.setItem('authToken', token);
    localStorage.setItem('user', JSON.stringify(userData));
  };

  // Show login screen if not authenticated
  if (!authToken) {
    return <Login onLoginSuccess={handleLoginSuccess} />;
  }

  return (
    <div className='app-background min-vh-100'>
      <Nav />
      <Container className='py-4'>
        <Tabs
          defaultActiveKey='health'
          id='mysummit-tabs'
          className='mb-3'
          fill
          variant='pills'
        >
          <Tab eventKey='health' title='Health Tracking'>
            <Container className='py-4 content-container'>
              <HealthTracking token={authToken} />
            </Container>
          </Tab>

          <Tab eventKey='labs' title='Lab Results'>
            <Container className='py-4 content-container'>
              <LabResults token={authToken} />
            </Container>
          </Tab>

          <Tab eventKey='calendar' title='Calendar'>
            <Container className='py-4 content-container'>
              <MyCalendar token={authToken} />
            </Container>
          </Tab>

          <Tab eventKey='messaging' title='Messaging'>
            <Container className='py-4 content-container'>
              <MessagingSystem token={authToken} />
            </Container>
          </Tab>

          <Tab eventKey='payments' title='Payments'>
            <Container className='py-4 content-container'>
              <Payments token={authToken} />
            </Container>
          </Tab>
        </Tabs>
      </Container>
    </div>
  );
}

export default App;
