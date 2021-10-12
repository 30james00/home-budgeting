import {useToast} from "vue-toastification";
import axios, {AxiosResponse} from "axios";
import {ICategory} from "../interfaces/ICategory";

export async function fetchCategories(): Promise<Array<ICategory> | null> {
    let response;
    try {
        response = await axios.get('/api/categories');
    } catch (e) {
        useToast().error("Error getting Categories")
        return null;
    }
    return response.data['hydra:member'] as Array<ICategory>;
}

export async function addCategory(category: ICategory):Promise<AxiosResponse> {
    return axios.post('/api/categories', category)
}