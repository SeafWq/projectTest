import axios from 'axios';

let appUrl = import.meta.env.BASE_URL;


const instance = axios.create({
    baseURL: appUrl,
});

instance.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    console.log('Отправляемые заголовки:', config.headers);
    return config;
}, error => {
    return Promise.reject(error);
});

export default instance;
