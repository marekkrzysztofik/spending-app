export function useDate() {
    function getMonth(date: any = new Date()) {
        const month = date.getMonth() + 1
        return month
    }
    function getYear(date: any = new Date()) {
        const year = date.getFullYear()
        return year
    }
    return { getMonth, getYear };
}
