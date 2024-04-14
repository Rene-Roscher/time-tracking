import moment from "moment";

/** Date Time Format */
export const format = (value, format) => moment(value).format(format)

/** Date Time Format */
export const dateTime = (value, format = 'DD.MM.YYYY - HH:mm') => this.format(value, format)

/** Date Format */
export const date = (value, format = 'DD.MM.YYYY') => this.format(value, format)

/** INTL Date Format */
export const intlDate = (value) => value ? new Intl.DateTimeFormat('default', { dateStyle: 'full' }).format(new Date(value)) : 'n/a'
/** INTL Time Format */
export const intlTime = (value) => value ? new Intl.DateTimeFormat('default', { timeStyle: 'short' }).format(new Date(value)) : 'n/a'

/** INTL Date Time Format */
export const intlDateTime = (value) => value ? new Intl.DateTimeFormat('default', { dateStyle: 'full', timeStyle: 'short' }).format(new Date(value)) : 'n/a'
