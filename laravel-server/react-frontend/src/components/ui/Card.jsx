
import '../../App.css';

export default function Card({ name, description }) {
  return (
    <div className="card">
      <h1>{name}</h1>
      <p>{description}</p>
    </div>
  );
}
