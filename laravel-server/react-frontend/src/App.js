
import './App.css';
import Button from './components/Button';
import Card from './components/ui/Card';
import Form from './components/ui/Form';
import List from './components/ui/List';
import Counter from './components/ui/Counter';


function App() {
  return (
    <div className="App">
      <h1>Hello React!</h1>

      <Card
        name="Bren"
        description="This is me"
      />

      <Card
        name="Jean"
        description="This is not me"
      />

      <Button />

      <Form />

      <List />

      <Counter />
      
    </div>
  );
}

export default App;
