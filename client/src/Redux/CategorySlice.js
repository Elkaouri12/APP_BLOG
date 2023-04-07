import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axios from "axios";





// const cache = {};
export const GetCategories=createAsyncThunk(
    'Get/Categories', async(_,thunkAPI)=>{
        const {rejectWithValue}=thunkAPI;
        try {

            const cachedCategories = thunkAPI.getState().Category.Categories;
            console.log('categories',cachedCategories)

            if (cachedCategories.length > 0) {
                return cachedCategories;
              }
         
           const res= await axios.get('http://127.0.0.1:8000/api/category',
           {
                headers: {
                'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${'4|e46kVu5RmxKmVHN507NYcEEnYgcQizZkLYu6uKfq'}`
                        }
           }
          )
            const data=res.data.data;
            return data
        } catch (error) {

        return rejectWithValue(error.message);  
        }
    }
)
const CategorySlice=createSlice({
    name:'Category',
    initialState:{
        isloding:false,
        error:null,
        Categories:[]
    },

    extraReducers:(builder) => {
        builder
    .addCase(GetCategories.fulfilled,(state,{payload})=>{
        state.Categories=payload
    })

}
})
export default CategorySlice.reducer