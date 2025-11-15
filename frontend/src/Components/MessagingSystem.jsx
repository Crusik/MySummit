import React, { useState, useEffect, useRef } from 'react';
import {
  MessageList,
  Input,
  Button,
  Navbar,
  ChatItem,
} from 'react-chat-elements';
import 'react-chat-elements/dist/main.css';
import './MessagingSystem.css';

const MessagingSystem = ({ token }) => {
  const [conversations, setConversations] = useState([]);
  const [activeChatId, setActiveChatId] = useState(null);
  const [inputValue, setInputValue] = useState('');
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const inputRef = useRef(null);
  const currentUserId = 1; // Get from auth context in production

  // Fetch conversations from backend
  useEffect(() => {
    setLoading(true);
    setError(null);
    fetch('http://localhost:8000/api/conversations', {
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
        console.log('Fetched conversations:', data);
        // Map backend data to react-chat-elements format
        const formatted = data.map((conv) => ({
          id: conv.id,
          name: conv.users.map((u) => u.name).join(', '),
          avatar: 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png',
          isOnline: true,
          messages: (conv.messages || []).map((m) => ({
            position: m.sender_id === currentUserId ? 'right' : 'left',
            type: 'text',
            text: m.text,
            date: new Date(m.created_at),
          })),
        }));

        setConversations(formatted);
        if (formatted.length) setActiveChatId(formatted[0].id);
        setLoading(false);
      })
      .catch((err) => {
        console.error('Error fetching conversations:', err);
        setError(err.message);
        setLoading(false);
      });
  }, []);

  const activeChat = conversations.find((c) => c.id === activeChatId);

  const handleSend = async () => {
    if (!inputValue.trim() || !activeChat) return;

    // Send message to backend
    try {
      const res = await fetch('http://localhost:8000/api/messages', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          conversation_id: activeChat.id,
          sender_id: 1, // current user ID
          text: inputValue,
        }),
      });
      const newMessage = await res.json();

      // Update local state
      setConversations((prev) =>
        prev.map((c) =>
          c.id === activeChatId
            ? {
                ...c,
                messages: [
                  ...c.messages,
                  {
                    position: 'right',
                    type: 'text',
                    text: newMessage.text,
                    date: new Date(newMessage.created_at),
                  },
                ],
              }
            : c,
        ),
      );

      setInputValue('');
    } catch (err) {
      console.error('Error sending message:', err);
    }
  };

  if (loading) {
    return (
      <div
        className='d-flex align-items-center justify-content-center bg-light'
        style={{ height: '70vh', width: '60vw' }}
      >
        <div>Loading conversations...</div>
      </div>
    );
  }

  if (error) {
    return (
      <div
        className='d-flex align-items-center justify-content-center bg-light'
        style={{ height: '70vh', width: '60vw' }}
      >
        <div className='text-danger'>Error: {error}</div>
      </div>
    );
  }

  return (
    <div
      className='d-flex bg-light messaging-wrapper'
      style={{ height: '70vh', width: '60vw' }}
    >
      {/* Sidebar */}
      <div className='col-4 bg-white border-end p-3 overflow-auto message-list-wrapper'>
        <h5 className='fw-semibold mb-3'>Conversations</h5>
        {conversations.length === 0 ? (
          <div className='text-muted'>No conversations yet</div>
        ) : (
          conversations.map((conv) => {
            const lastMessage =
              conv.messages[conv.messages.length - 1]?.text || '';
            const truncatedMessage =
              lastMessage.length > 30
                ? lastMessage.slice(0, 30) + '…'
                : lastMessage;

            return (
              <ChatItem
                key={conv.id}
                avatar={conv.avatar}
                alt={conv.name}
                title={conv.name}
                subtitle={truncatedMessage}
                date={conv.messages[conv.messages.length - 1]?.date}
                unread={0}
                onClick={() => setActiveChatId(conv.id)}
                className={`cursor-pointer ${
                  activeChatId === conv.id ? 'bg-primary-subtle' : ''
                }`}
              />
            );
          })
        )}
      </div>

      {/* Chat area */}
      <div className='col d-flex flex-column p-3'>
        {activeChat && (
          <>
            <Navbar
              left={
                <div className='d-flex align-items-center gap-2'>
                  <img
                    src={activeChat.avatar}
                    alt={activeChat.name}
                    className='rounded-circle'
                    width='36'
                    height='36'
                  />
                  <div className='fw-semibold'>{activeChat.name}</div>
                </div>
              }
              right={
                <div
                  style={{ color: activeChat.isOnline ? 'green' : 'gray' }}
                  className='small'
                >
                  {activeChat.isOnline ? 'Online' : 'Offline'}
                </div>
              }
              type='light'
            />

            <div className='flex-grow-1 overflow-auto p-3 bg-body-tertiary'>
              <MessageList
                className='message-list'
                lockable={true}
                toBottomHeight={'100%'}
                dataSource={activeChat.messages}
              />
            </div>

            <div className='d-flex align-items-center mt-3'>
              <Input
                placeholder='Type a message...'
                value={inputValue}
                onChange={(e) => setInputValue(e.target.value)}
                onKeyDown={(e) => {
                  if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    handleSend();
                  }
                }}
                rightButtons={
                  <Button
                    text='Send'
                    onClick={handleSend}
                    title='Send'
                    backgroundColor='#0a66c2'
                    color='#fff'
                  />
                }
              />
            </div>
          </>
        )}
      </div>
    </div>
  );
};

export default MessagingSystem;
