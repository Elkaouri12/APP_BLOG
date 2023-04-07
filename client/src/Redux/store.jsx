import { configureStore } from "@reduxjs/toolkit";
import CategorySlice from "./CategorySlice";

const store=configureStore({
    reducer: {
       Category:CategorySlice
    }
})

export default store;