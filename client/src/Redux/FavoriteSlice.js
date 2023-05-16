import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axios from "axios";





export const GetFavories=createAsyncThunk(
    'Get/favorites', async(_,thunkAPI)=>{
        const {rejectWithValue}=thunkAPI;
        try {

            const cachedfavorite = thunkAPI.getState().Favorite.Favorites;
            console.log('favorite',cachedfavorite)

            if (cachedfavorite.length > 0) {
                return cachedfavorite;
              }
         
           const res= await axios.get('http://127.0.0.1:8000/api/favorite',
           {
                headers: {
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
const FavoriteSlice=createSlice({
    name:'user',
    initialState:{
        isloding:false,
        error:null,
        Favorites:[]
    },

    extraReducers:(builder) => {
        builder
    .addCase(GetFavories.fulfilled,(state,{payload})=>{
        state.Favorites=payload
    })

}
})
export default FavoriteSlice.reducer