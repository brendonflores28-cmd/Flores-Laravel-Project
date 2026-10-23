
import { useState, useEffect } from 'react';
import { getPost, storePost } from '../../api/post';
import './styles/post.css';
import PostCard from './PostCard';

function extractPosts(data) {
    if (Array.isArray(data)) return data;
    if (Array.isArray(data?.data)) return data.data;
    if (Array.isArray(data?.data?.data)) return data.data.data;
    if (Array.isArray(data?.posts)) return data.posts;
    return [];
}

export default function Post() {
    const [posts, setPosts] = useState([]);
    const [message, setMessage] = useState('');
    const [error, setError] = useState('');
    const [processing, setProcessing] = useState(false);

    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const response = await getPost();
                setPosts(extractPosts(response.data));
            } catch (err) {
                console.error("Failed to load posts", err);
                setError('Failed to load posts: ' + err.message);
            }
        };

        fetchPosts();
    }, []);

    useEffect(() => {
        if (message.trim() && error === 'Post cannot be empty') {
            setError('');
        }
    }, [message, error]);


const submit = async (e) => {
    e.preventDefault();

    if (!message.trim()) {
        setError('Post cannot be empty');
        return;
    }

    setProcessing(true);
    setError('');

    try {
        const response = await storePost({ message });

        const newPost = response.data.data || response.data;

        setPosts((prevPosts) => [newPost, ...prevPosts]);

        setMessage('');
    } catch (err) {
        const errMsg =
            err.response?.data?.message ||
            err.message ||
            'Failed to share post. Please try again.';

        setError(errMsg);
    } finally {
        setProcessing(false);
    }
};


    return (
        <div className="post-container">
            <h1>My Posts</h1>

            <form onSubmit={submit} className="post-form">
                <textarea
                    value={message}
                    onChange={(e) => setMessage(e.target.value)}
                    placeholder="What's on your mind?"
                    rows="4"
                />

                {error && (
                    <p className="post-error">{error}</p>
                )}

                <button type="submit" disabled={processing}>
                    {processing ? 'Posting...' : 'Create Post'}
                </button>
            </form>

            <h2>Recent Posts</h2>

            <div className="post-list">
                {posts.length === 0 ? (
                    <p>No posts available.</p>
                ) : (
                    posts.map((post, index) => (
                        <PostCard
                            key={post.id ?? index}
                            post={post}
                        />
                    ))
                )}
            </div>
        </div>
    );
}
