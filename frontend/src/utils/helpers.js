import { objectGet } from './object'

const Buffer = require("buffer").Buffer;

export function isEmpty(obj) {
    if (typeof (obj) == 'undefined' || obj === null) return true;
    if (typeof (obj) == 'number') return false;
    if (typeof (obj) == 'boolean') return false;
    if (isArray(obj) || isString(obj)) return obj.length === 0;
    for (let key in obj) if (Object.prototype.hasOwnProperty.call(obj, key)) return false;
    return true;
}

export function isValidFile(file){
    if (typeof (file) == 'undefined' || file === null) return true;
    if(typeof (file) == 'object' ||  file.size == 0){
        return false;
    }
    return true;
}

export function isNotEmpty(obj) {
    return !isEmpty(obj)
}

export function isArray(array) {
    return Array.isArray(array);
}

export function isString(obj) {
    return !!(obj === '' || (obj && obj.charCodeAt && obj.substr));
}

export function isNumber(obj) {
    return typeof obj === 'number' && isFinite(obj);
}

export function findInArrayOfObjects(obj, key, value, need) {
    if(isNotEmpty(obj) && isNotEmpty(value)) {
        let result = obj.find((item) => {
            if(objectGet(item, `${key}`)) {
                if(item[key].toString() === value.toString()) {
                    return item;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        });
        if (isNotEmpty(result)) {
            if (isNotEmpty(need)) {
                return result[need];
            } else {
                return result;
            }
        }
    } else {
        return null;
    }
}

export function indexOfArrayOfObjects(obj, key, value) {
    let result = null;
    if(isNotEmpty(obj) && isNotEmpty(value)) {
        obj.find((item, index) => {
            if(objectGet(item, `${key}`)) {
                if(item[key].toString() === value.toString()) {
                    result = index;
                }
            }
        });
    }
    return result;
}

export function isTablet() {
    return false;
}

export function keyValueToIdName(keyValue) {
    return Object.keys(keyValue).map((id) => {
        return {
            id,
            name: keyValue[id]
        }
    })
}
export function Base64Encode(str) {
    return new Buffer(str).toString("base64");
}

export function clearNonNumericChars(string) {
    if(typeof string != 'string') return string;

    return string.replace(/\D/g,'');
}

export function strObjectName(fieldName, fields) {
    let strObjectName = fieldName;
    if (isNotEmpty(fields[fieldName])) {
        strObjectName = fields[fieldName]['name'].replace('[]', '').replace('[', '.').replace(']', '');
    }
    return strObjectName;
}

export function arrayItemsToString(items) {
    let results = [];

    if(items.indexOf('*') !== -1) {
        results = items;
    } else {
        for(let i = 0; i < items.length; i++) {
            results.push(items[i].toString());
        }
    }

    return results;
}

export function numberWithCommas(x) {
    let parts = x.toString().split(".");
    if(isNotEmpty(parts[1]) && parts[1].length > 2) {
        parts = ( parseFloat(parts.join(".")).toFixed(2) * 100 ) / 100;
        parts = parts.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        parts = parts.join(".");
    } else {
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        parts = parts.join(".");
    }
    return parts;
}

export function b64EncodeUnicode(str) {
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
        }));
}

export function b64DecodeUnicode(str) {
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
}