import React, { useState } from 'react';
import { Container, Form, Button, Alert, Card } from 'react-bootstrap';
import './Login.css';

const Login = ({ onLoginSuccess }) => {
  const [email, setEmail] = useState('michael@example.com');
  const [password, setPassword] = useState('password123');
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);

  const handleLogin = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    try {
      console.log('Attempting login with:', { email, password });

      const response = await fetch('http://localhost:8000/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password }),
      });

      console.log('Response status:', response.status);
      const text = await response.text();
      console.log('Response text:', text);

      if (!response.ok) {
        try {
          const errorData = JSON.parse(text);
          console.error('Error data:', errorData);
          throw new Error(
            errorData.message || `Login failed with status ${response.status}`,
          );
        } catch (e) {
          throw new Error(`Server error: ${text.substring(0, 100)}`);
        }
      }

      const data = JSON.parse(text);
      console.log('Login successful:', data);

      onLoginSuccess(data.token, data.user);
    } catch (err) {
      console.error('Login error:', err);
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className='login-page min-vh-100 d-flex align-items-center justify-content-center bg-light'>
      <Container>
        <div className='row justify-content-center'>
          <div className='col-md-5'>
            <Card className='shadow-lg'>
              <Card.Body className='p-5'>
                <h1 className='text-center mb-4'>MySummit</h1>
                <h2 className='text-center h4 mb-4 text-muted'>
                  Patient Portal
                </h2>

                {error && <Alert variant='danger'>{error}</Alert>}

                <Form onSubmit={handleLogin}>
                  <Form.Group className='mb-3'>
                    <Form.Label>Email Address</Form.Label>
                    <Form.Control
                      type='email'
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                      placeholder='Enter email'
                      disabled={loading}
                    />
                  </Form.Group>

                  <Form.Group className='mb-4'>
                    <Form.Label>Password</Form.Label>
                    <Form.Control
                      type='password'
                      value={password}
                      onChange={(e) => setPassword(e.target.value)}
                      placeholder='Enter password'
                      disabled={loading}
                    />
                  </Form.Group>

                  <Button
                    variant='primary'
                    size='lg'
                    className='w-100'
                    type='submit'
                    disabled={loading}
                  >
                    {loading ? 'Logging in...' : 'Login'}
                  </Button>
                </Form>

                <hr />

                <div className='alert alert-info mt-4' role='alert'>
                  <small>
                    <strong>Demo Credentials:</strong>
                    <br />
                    Email: michael@example.com
                    <br />
                    Password: password123
                  </small>
                </div>
              </Card.Body>
            </Card>
          </div>
        </div>
      </Container>
    </div>
  );
};

export default Login;
