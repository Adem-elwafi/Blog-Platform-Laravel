// Comments.jsx
import React, { useState, useEffect } from 'react';
import axios from 'axios';

export default function Comments({ postId, user }) {
  const [comments, setComments] = useState([]);
  const [newComment, setNewComment] = useState("");

  useEffect(() => {
axios.get(`/posts/${postId}`)
  .then(res => setComments(res.data.comments || []));

  }, [postId]);

  const handleAddComment = async () => {
    if (!newComment.trim()) return;
    const res = await axios.post(`/posts/${postId}/comments`, { body: newComment });
    setComments([...comments, res.data]); // optimistic update
    setNewComment("");
  };

  const handleDeleteComment = async (id) => {
    await axios.delete(`/comments/${id}`);
    setComments(comments.filter(c => c.id !== id));
  };

  return (
    <div>
      <h3>Comments</h3>
<ul>
  {Array.isArray(comments) && comments.map(c => (
    <li key={c.id}>{c.body}</li>
  ))}
</ul>

      <textarea 
        value={newComment} 
        onChange={e => setNewComment(e.target.value)} 
        placeholder="Write a comment..."
      />
      <button onClick={handleAddComment}>Add Comment</button>
    </div>
  );
}
