export function formDate(date?: string): string {
    const d = date ? new Date(date) : new Date();

    return d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" +
        ("0" + d.getDate()).slice(-2)
}

export function toDashDate(d: Date): string {
    return d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" +
        ("0" + d.getDate()).slice(-2)
}

export function formTime(date?: string): string {
    const d = date ? new Date(date) : new Date();

    return ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2)
}