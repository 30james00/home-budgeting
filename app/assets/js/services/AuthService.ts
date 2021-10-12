import axios, {AxiosResponse} from "axios";
import {useToast} from "vue-toastification";

export function login(email: string, password: string): Promise<AxiosResponse> {
    return axios.post('/login', {
        email,
        password,
    })
}

export async function logout(): Promise<void> {
    try {
        await axios.post('/logout')
        useToast().success("User logged out")
    } catch (e) {
        useToast().error("Error logging out")
    }
}