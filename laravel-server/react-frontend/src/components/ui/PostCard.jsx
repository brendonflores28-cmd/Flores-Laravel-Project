
export default function PostCard({ post }) {
    return (
        <div className="post-card">
            <p>{post.message ?? post.content ?? post.body}</p>

            {post.created_at && (
                <small>
                    {new Date(post.created_at).toLocaleString()}
                </small>
            )}
        </div>
    );
}
