
import { useState } from "react";

export default function Form() {
  const [name, setName] = useState("");

  function handleSubmit(e) {
    e.preventDefault();
    console.log(name);
    alert("Submitted name: " + name);
  }

  return (
    <form onSubmit={handleSubmit}>
      <input
        type="text"
        value={name}
        onChange={(e) => setName(e.target.value)}
        placeholder="Input your name"
      />

      <button type="submit">Submit</button>
    </form>
  );
}
 