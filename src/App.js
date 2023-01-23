import { Route, Routes } from 'react-router-dom';
import './App.css';
import AdminPanel from './Components/AdminPanel/AdminPanel';
import Content from './Components/Contents/Content';
import Header from './Components/Header/Header';

function App() {
  return (
    <div className="App">
        <Header/>
        <Routes>
          <Route path='/' element={<Content/>}/>
          <Route path='adminPanel' element={<AdminPanel/>}/>
        </Routes>
    </div>
  );
}

export default App;
