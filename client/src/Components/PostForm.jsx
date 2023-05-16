import axios from 'axios';
import React, {  useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../styles/PostForm.css'
import {  useSelector } from 'react-redux';

const PostForm = () => {
  const {Categories}=useSelector(state=>state.Category);
  const [formData, setFormData] = useState({
    title: '',
    category_id: '',
    heading_image: '',
    descriptions: [
      {
        heading: '',
        description: '',
        image: null
      }
    ]
  });
//---------------------Title & category_id--------------------------------------
  const handleInputChange = (event) => {
    const { name, value } = event.target;
    // console.log('name',name) // category_id,title
    // setFormData({ ...formData, [title]: "im title" });
    setFormData({ ...formData, [name]: value });
  };
//----------------------Description heading ,description.description---------------
  const handleDescriptionInputChange = (index, event) => {
    const { name, value } = event.target;
    const updatedDescriptions = [...formData.descriptions];
    updatedDescriptions[index] = { ...updatedDescriptions[index], [name]: value };
    setFormData({ ...formData, descriptions: updatedDescriptions });
  };

//-----------------------------------------------------------------------------------
const handleImageInputChange = (index, event) => {
  const file = event.target.files[0];
  const reader = new FileReader();
  reader.onload = () => {
    const url = URL.createObjectURL(file);
    const updatedDescriptions = [...formData.descriptions];
    updatedDescriptions[index] = { ...updatedDescriptions[index], image: file };
    setFormData({ ...formData, descriptions: updatedDescriptions });
  };
  reader.readAsDataURL(file);
};


  //--------------------------heading image-----------------------------------
  const handleHeadingImage = ( event) => {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
      const url = URL.createObjectURL(file);
      setFormData({ ...formData, heading_image: file });
    };
    reader.readAsDataURL(file);
  };



// ------------------------add more filed-----------------------------------
  const handleAddDescription = () => {
    setFormData({
      ...formData,
      descriptions: [ ...formData.descriptions,
        {
          heading: '',
          description: '',
          image: null
        }
      ]
    });
  };


  const handleSubmit = async (event) => {
    event.preventDefault();
    const mydata=new FormData();
    const data = new FormData();
    data.append('title', formData.title);
    data.append('category_id', formData.category_id);
    data.append('heading_image', formData.heading_image);
    // data.append('heading_image', formData.descriptions[0].image);
    // mydata.append(formData.descriptions[0].image)

    formData.descriptions.map((description, index) => {
      data.append(`descriptions[${index}][heading]`, description.heading);
      data.append(`descriptions[${index}][description]`, description.description);
      data.append(`descriptions[${index}][test]`, "test");
      
      if (description.image) {
        console.log('description.image',description.image); //  it shows the picture info
        // data.append(`descriptions[${index}][image]`,(formData.descriptions[0].image)); // return description image null
        data.append(`descriptions[${index}][image]`,(formData.heading_image)); // return description image null
        // data.append(`descriptions[${index}][image]`,'image string');// return the image exist 
      }
    });
    try {

      const response = await axios.post('http://127.0.0.1:8000/api/post', data, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Authorization': `Bearer ${'3|HO5L0GQ0VwLdt5ZMtLoqV883TMXiwUJFrBQ9gHE4'}`
        }
      });
      console.log(response.data);
      
    
    } catch (error) {
      console.error(error);
    }
  };



  
  return (
<div className='container border border-primary rounded mx-auto' >
<form onSubmit={handleSubmit} className="form">
  <div className="form-group mt-5">
    <label htmlFor="title" className=''>Title:</label>
    <input type="text" className="form-control" id="title" name="title" value={formData.title} onChange={handleInputChange} />
  </div>
  <div className="form-group">
    <label htmlFor="category_id">Category ID:</label>  

    <select   value={formData.category_id} className='form-control' name="category_id" id="category_id" onChange={handleInputChange}>
            {Categories.map(item=>(
              <option key={item.id} value={item.id}>{item.name}</option>
            ))}
    </select>
  </div>
  <div className="form-group d-flex">
    <label htmlFor="heading_image">Heading Image:</label>
    <div className="custom-file ">
      <input type="file" className="custom-file-input" id="heading_image" name="heading_image" onChange={(e) => handleHeadingImage(e)} />
      <label className="custom-file-label ms-4" htmlFor="heading_image">Choose file</label>
    </div>
    {formData.heading_image && (
      <img src={URL.createObjectURL(formData.heading_image)} alt="Heading Image" className="form__image" />
    )}
  </div>
  {formData.descriptions.map((description, index) => (
    <div key={index} className="form__description">
      <div className="form-group">
        <label htmlFor={`description_${index}_heading`}>Description Heading:</label>
        <input type="text" className="form-control" id={`description_${index}_heading`} name="heading" value={description.heading} onChange={(event) => handleDescriptionInputChange(index, event)} />
      </div>
      <div className="form-group">
        <label htmlFor={`description_${index}_description`}>Description:</label>
        <textarea className="form-control" id={`description_${index}_description`} name="description" value={description.description} onChange={(event) => handleDescriptionInputChange(index, event)} ></textarea>
      </div>
      <div className="form-group  d-flex ">
        <label htmlFor={`description_${index}_image`}>Description Image:</label>
        <div className="custom-file ">
          <input type="file" className="custom-file-input" id={`description_${index}_image`} name="image" onChange={(event) =>handleImageInputChange(index, event)} />
          <label className="custom-file-label ms-4" htmlFor={`description_${index}_image`}>Choose file</label>
        </div>
        {description.image && (
          <img src={URL.createObjectURL(description.image)} alt="Description Image" className="form__image" />
        )}
      </div>
    </div>
  ))}
  <div className='d-felx'>
  <button id='add_description' type="button" className="btn btn-secondary" onClick={handleAddDescription}>Add Description</button>
  <svg id='add_description' className='ms-3' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width={24} height={24} >
      <path fill={'black'} d="M19 11h-6V5c0-.6-.4-1-1-1s-1 .4-1 1v6H5c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1v-6h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
</svg>
  </div>
  <div className='sub_container'>
  <button type="submit" className="">Submit</button>
  </div>
</form>
</div>
  );
};

export default PostForm
