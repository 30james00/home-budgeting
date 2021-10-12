import axios, {AxiosResponse} from "axios";
import {ITransaction} from "../interfaces/ITransaction";
import {useToast} from "vue-toastification";
import {ITransactionFilter} from "../interfaces/ITransactionFilter";
import {normalizeFormValue} from "../helpers/NumberHelpers";
import {toDashDate} from "../helpers/DateHelpers";

/**
 * Fetch all Transactions
 */
export async function fetchTransactions(filters: ITransactionFilter): Promise<Array<ITransaction> | null> {
    let response;
    let url = "/api/transactions?";
    if (filters.order !== "") {
        url += "order"
        switch (filters.order) {
            case "dateDesc":
                url += "[createDate]=desc"
                break;
            case "dateAsc":
                url += "[createDate]=asc"
                break;
            case "valueDesc":
                url += "[value]=desc"
                break;
            case "valueAsc":
                url += "[value]=asc"
                break;
        }
        url += "&"
    }
    let from = new Date()
    switch (filters.dateRange) {
        case "week":
            from.setDate(from.getDate() - 7)
            url += `createDate[after]=${toDashDate(from)}`
            break;
        case "month":
            from.setMonth(from.getMonth() - 1)
            url += `createDate[after]=${toDashDate(from)}`
            break;
        case "3month":
            from.setMonth(from.getMonth() - 3)
            url += `createDate[after]=${toDashDate(from)}`
            break;
        case "year":
            from.setFullYear(from.getFullYear() - 1)
            url += `createDate[after]=${toDashDate(from)}`
            break;
        case "5year":
            from.setFullYear(from.getFullYear() - 5)
            url += `createDate[after]=${toDashDate(from)}`
            break;
        case "custom":
            if (filters.fromDate !== "") url += `createDate[before]=${filters.fromDate}&`
            if (filters.toDate !== "") url += `createDate[after]=${filters.toDate}&`
            break;
    }
    if (filters.minValue !== "") url += `value[gte]=${normalizeFormValue(filters.minValue)}&`
    if (filters.maxValue !== "") url += `value[lte]=${normalizeFormValue(filters.maxValue)}&`
    try {
        response = await axios.get(url);
    } catch (e) {
        useToast().error("Error fetching Transactions")
        return null;
    }
    return response.data['hydra:member'] as Array<ITransaction>;
}

/**
 * Get one Transaction by its id
 * @param id Transaction id
 */
export function getTransaction(id: string): Promise<AxiosResponse> {
    return axios.get(`/api/transactions/${id}`);
}

/**
 * Persist new Transaction
 * @param transaction New Transaction object
 */
export function addTransaction(transaction: ITransaction): Promise<AxiosResponse> {
    return axios.post('/api/transactions', transaction)
}

/**
 * Edit chosen Transaction
 * @param transaction Changed Transaction object with unchanged id
 */
export function editTransaction(transaction: ITransaction): Promise<AxiosResponse> {
    const id = transaction.id
    return axios.put(`/api/transactions/${id}`, transaction)
}

/**
 * Delete chosen Transaction
 * @param id Id of Transaction to delete
 */
export function deleteTransaction(id: string): Promise<AxiosResponse> {
    return axios.delete(id)
}