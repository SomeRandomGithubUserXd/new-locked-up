export const getCurrentUrlParam = (param) => {
    return (new URLSearchParams(location.search)).get(param) || null
}
