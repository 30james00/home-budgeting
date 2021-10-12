import axios from "axios";
import {IStatistics} from "../interfaces/IStatistics";
import {useToast} from "vue-toastification";
import {ICategorySum} from "../interfaces/ICategorySum";
import {IPeriodBalance} from "../interfaces/IPeriodBalance";

export async function getStatistics(from: string, to?: string): Promise<IStatistics | null> {
    let response;
    let url = `/api/statistics?from=${from}`
    if (to) url += `&to=${to}`
    try {
        response = await axios.get(url);
    } catch (e) {
        useToast().error("Error getting Statistics")
        return null;
    }
    return response.data['hydra:member'][0] as IStatistics;
}

export async function fetchCategorySums(from: string, to?: string): Promise<Array<ICategorySum> | null> {
    let response;
    let url = `/api/category-sums?from=${from}`
    if (to) url += `&to=${to}`
    try {
        response = await axios.get(url);
    } catch (e) {
        useToast().error("Error fetching Expenditures by category chart")
        return null;
    }
    return response.data['hydra:member'] as Array<ICategorySum>;
}

export async function fetchPeriodBalance(period: string, from: string, to?: string): Promise<Array<IPeriodBalance> | null> {
    let response;
    let url = `/api/period-balances?period=${period}&from=${from}`
    if (to) url += `&to=${to}`
    try {
        response = await axios.get(url);
    } catch (e) {
        useToast().error("Error fetching Period balance")
        return null;
    }
    return response.data['hydra:member'] as Array<IPeriodBalance>;
}