import axios from "axios";
import {useToast} from "vue-toastification";
import {IUser} from "../interfaces/IUser";

export async function fetchUsers(): Promise<IUser | null> {
    let response;
    try {
        response = await axios.get(`/api/users`);
    } catch (e) {
        useToast().error("Error fetching Users")
        return null;
    }
    return response.data['hydra:member'][0] as IUser;
}

export async function getUser(iri: string): Promise<IUser | null> {
    let response;
    try {
        response = await axios.get(iri);
    } catch (e) {
        useToast().error("Error fetching User")
        return null;
    }
    return response.data as IUser;
}