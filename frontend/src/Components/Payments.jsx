import React, { useState, useEffect } from 'react';
// import { loadStripe } from "@stripe/stripe-js";
// import { Elements, CardElement, useStripe, useElements } from "@stripe/react-stripe-js";
import { Button, Form, Card } from 'react-bootstrap';
import './Payments.css';

// const stripePromise = loadStripe("pk_test_your_public_key_here"); // replace with your test key

const CheckoutForm = ({ token }) => {
  // const stripe = useStripe();
  // const elements = useElements();
  const [amount, setAmount] = useState('');
  const [description, setDescription] = useState('');
  const [payments, setPayments] = useState([]);
  const [loading, setLoading] = useState(false);

  // Fetch payments from backend
  useEffect(() => {
    if (!token) return;

    fetch('http://localhost:8000/api/payments', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
      .then((res) => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
      })
      .then((data) => {
        console.log('Payments from API:', data);
        setPayments(data);
      })
      .catch((err) => {
        console.error('Failed to load payments', err);
      });
  }, [token]);

  const handlePayment = async (e) => {
    e.preventDefault();

    // if (!stripe || !elements) return;
    if (!amount || amount <= 0) {
      alert('Please enter a valid amount.');
      return;
    }

    setLoading(true);

    // Placeholder — will connect to backend/Stripe later
    alert(`Payment of $${amount} ready to process (backend needed next).`);
    setAmount('');

    setLoading(false);
  };

  return (
    <Card
      className='p-4 shadow-sm rounded-4'
      style={{ maxWidth: '500px', margin: '0 auto' }}
    >
      <h3 className='text-center mb-4 text-primary fw-bold'>Make a Payment</h3>

      <Form onSubmit={handlePayment}>
        <Form.Group className='mb-3' controlId='paymentAmount'>
          <Form.Label>Enter Amount</Form.Label>
          <Form.Control
            type='number'
            step='0.01'
            min='0'
            placeholder='Enter amount (USD)'
            value={amount}
            onChange={(e) => setAmount(e.target.value)}
          />
        </Form.Group>

        <Form.Group className='mb-3' controlId='paymentDescription'>
          <Form.Label>Description</Form.Label>
          <Form.Control
            type='text'
            placeholder='What is this payment for?'
            value={description}
            onChange={(e) => setDescription(e.target.value)}
          />
        </Form.Group>

        <div className='d-grid'>
          <Button
            type='submit'
            variant='primary'
            size='lg'
            disabled={loading}
            className='rounded-3'
          >
            {loading ? 'Processing...' : 'Pay Now'}
          </Button>
        </div>
      </Form>

      <hr className='my-4' />

      <h5 className='text-center text-secondary mb-3'>Past Payments</h5>
      {payments.length > 0 ? (
        <div className={payments.length > 3 ? 'payments-list-container' : ''}>
          <ul className='list-group'>
            {payments.map((p) => (
              <li key={p.id} className='list-group-item'>
                <div className='d-flex justify-content-between align-items-start'>
                  <div className='flex-grow-1'>
                    <div className='mb-2'>
                      <span className='fw-bold'>
                        $
                        {typeof p.amount === 'number'
                          ? p.amount.toFixed(2)
                          : p.amount}
                      </span>
                      <span className='ms-2 badge bg-secondary'>
                        {p.status}
                      </span>
                    </div>
                    {p.description && (
                      <p className='mb-1 text-muted small'>{p.description}</p>
                    )}
                  </div>
                  <small className='text-muted ms-2'>
                    {p.paid_at
                      ? new Date(p.paid_at).toLocaleDateString()
                      : 'Pending'}
                  </small>
                </div>
              </li>
            ))}
          </ul>
        </div>
      ) : (
        <p className='text-center text-muted'>No previous payments found.</p>
      )}
    </Card>
  );
};

const PaymentPage = ({ token }) => (
  <div className='container'>
    <CheckoutForm token={token} />
  </div>
);

export default PaymentPage;
