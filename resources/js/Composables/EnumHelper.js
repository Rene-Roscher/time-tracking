// Readable Options by Enum Object
export const readableOptions = (enumObject) => {
    return Object.keys(enumObject).map(key => {
        return {
            id: enumObject[key],
            name: readableKey(key)
        }
    })
}

export const readableKey = (key) => {
    return key.toLowerCase().replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
}

// Get the key by value from an Enum Object
export const getKeyByValue = (enumObject, value) => {
    return Object.keys(enumObject).find(key => enumObject[key] === value)
}

export const getReadableValue = (enumObject, value) => {
    return readableKey(getKeyByValue(enumObject, value))
}
