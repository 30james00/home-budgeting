import {ICurrency} from "../interfaces/ICurrency";
import {useToast} from "vue-toastification";
import axios from "axios";

export async function fetchCurrencies(): Promise<Array<ICurrency> | null> {
    let response;
    try {
        response = await axios.get('/api/currencies');
    } catch (e) {
        useToast().error("Error getting Currencies")
        return null;
    }
    return response.data['hydra:member'] as Array<ICurrency>;
}