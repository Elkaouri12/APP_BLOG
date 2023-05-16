import { configureStore } from "@reduxjs/toolkit";
import CategorySlice from "./CategorySlice";
import UsersSlice from "./UsersSlice";
import FavoriteSlice from "./FavoriteSlice";

const store=configureStore({
    reducer: {
       Category:CategorySlice,
       User:UsersSlice,
       Favorite:FavoriteSlice
    }
})

export default store;