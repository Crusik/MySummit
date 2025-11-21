import React, { useState, useEffect } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import { Container, Tabs, Tab } from 'react-bootstrap';
import { FaBars, FaTimes } from 'react-icons/fa';

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
  const [menuOpen, setMenuOpen] = useState(false);
  const [activeTab, setActiveTab] = useState('health');

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

  const tabs = [
    { key: 'health', title: 'Health Tracking', component: HealthTracking },
    { key: 'labs', title: 'Lab Results', component: LabResults },
    { key: 'calendar', title: 'Calendar', component: MyCalendar },
    { key: 'messaging', title: 'Messaging', component: MessagingSystem },
    { key: 'payments', title: 'Payments', component: Payments },
  ];

  const CurrentComponent = tabs.find((t) => t.key === activeTab)?.component;

  return (
    <div className='app-background min-vh-100'>
      <Nav />

      {/* Desktop Navigation */}
      <Container className='py-4 desktop-nav'>
        <Tabs
          activeKey={activeTab}
          onSelect={(k) => {
            setActiveTab(k);
            setMenuOpen(false);
          }}
          id='mysummit-tabs'
          className='mb-3'
          fill
          variant='pills'
        >
          {tabs.map((tab) => (
            <Tab key={tab.key} eventKey={tab.key} title={tab.title}>
              <Container className='py-4 content-container'>
                <tab.component token={authToken} />
              </Container>
            </Tab>
          ))}
        </Tabs>
      </Container>

      {/* Mobile Navigation */}
      <div className='mobile-nav'>
        <div className='mobile-nav-header'>
          <button
            className='hamburger-btn'
            onClick={() => setMenuOpen(!menuOpen)}
          >
            {menuOpen ? <FaTimes size={24} /> : <FaBars size={24} />}
          </button>
          <h2 className='mobile-tab-title'>
            {tabs.find((t) => t.key === activeTab)?.title}
          </h2>

          {menuOpen && (
            <div className='mobile-menu'>
              {tabs.map((tab) => (
                <button
                  key={tab.key}
                  className={`mobile-menu-item ${
                    activeTab === tab.key ? 'active' : ''
                  }`}
                  onClick={() => {
                    setActiveTab(tab.key);
                    setMenuOpen(false);
                  }}
                >
                  {tab.title}
                </button>
              ))}
            </div>
          )}
        </div>

        <Container className='py-4 content-container'>
          {CurrentComponent && <CurrentComponent token={authToken} />}
        </Container>
      </div>
    </div>
  );
}

export default App;
