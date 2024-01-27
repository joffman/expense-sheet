export function formatDate(date) {
    if (!(date instanceof Date)) {
        return "";
    }

    const formattedYear = date.getFullYear();
    const formattedMonth = (date.getMonth() + 1).toString().padStart(2, "0");
    const formattedDay = (date.getDay()).toString().padStart(2, "0");
    const formatted = `${formattedYear}-${formattedMonth}-${formattedDay}`;

    return formatted;
}