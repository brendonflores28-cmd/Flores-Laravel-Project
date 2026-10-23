
import { useState, useEffect } from "react";

export default function Counter() {
  const [count, setCount] = useState(0);

  // Run side effects after render
  useEffect(() => {
    document.title = `Count: ${count}`;
  }, [count]);

  return (
    <button
      className="counter-button"
      onClick={() => setCount(count + 1)}
   >
        Count: {count}
   </button>
  );
}
