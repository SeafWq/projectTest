import axios from 'axios';

let appUrl = import.meta.env.BASE_URL;

const instance = axios.create({
    baseURL: appUrl,
});

export default instance;
