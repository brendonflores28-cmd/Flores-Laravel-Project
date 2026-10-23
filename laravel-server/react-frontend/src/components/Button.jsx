
function Button() {
  function handleClick() {
    alert("Button Clicked!");
  }

  return (
    <div>
      <button className="custom-button" onClick={handleClick}>
        Click Me
      </button>
    </div>
  );
}

export default Button;
