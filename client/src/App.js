import { useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route ,Navigate } from "react-router-dom";

import PostForm from './Components/PostForm';
 import { GetCategories } from './Redux/CategorySlice';
 import { useDispatch } from 'react-redux';
 import NavBar from './Components/NavBar';

function App() {

  // const dispatch=useDispatch();
  // useEffect(()=>{
  //   dispatch(GetCategories());

  // },[])
  return (

<>


<NavBar/>
  <Router>
            <Routes>
             <Route path="/add-post" element={<PostForm/>} />


                  
           </Routes>
   </Router>
</> 
  

         

  );
}

export default App;

