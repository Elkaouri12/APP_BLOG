import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axios from "axios";





export const GetUsers=createAsyncThunk(
    'Get/users', async(_,thunkAPI)=>{
        const {rejectWithValue}=thunkAPI;
        try {

            const cachedUsers = thunkAPI.getState().User.Users;
            console.log('users',cachedUsers)

            if (cachedUsers.length > 0) {
                return cachedUsers;
              }
         
           const res= await axios.get('http://127.0.0.1:8000/api/users',
           {
                headers: {
                'Authorization': `Bearer ${'4|e46kVu5RmxKmVHN507NYcEEnYgcQizZkLYu6uKfq'}`
                 }
           }
          )
            const data=res.data;
            return data
        } catch (error) {

        return rejectWithValue(error.message);  
        }
    }
)
const UsersSlice=createSlice({
    name:'user',
    initialState:{
        isloding:false,
        error:null,
        Users:[]
    },

    extraReducers:(builder) => {
        builder
    .addCase(GetUsers.fulfilled,(state,{payload})=>{
        state.Users=payload
    })

}
})
export default UsersSlice.reducer