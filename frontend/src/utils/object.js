
const reverseDupArray = function (array) {
    let result = new Array(array.length);
    let index  = array.length;
    let arrayMaxIndex = index - 1;

    while (index--) {
        result[arrayMaxIndex - index] = array[index];
    }

    return result;
};

export function objectGet(object, path, defaultVal = null) {
    if ((object === undefined) || (object === null) || (path === undefined) || (path === null)) {
        return defaultVal;
    }

    let names;

    if (typeof path === "string") {
        names = path.split('.').reverse();
    } else if (Array.isArray(path)) {
        names = reverseDupArray(path);
    }

    while (names.length && (object = object[names.pop()]) !== undefined && object !== null);

    // Handle cases where accessing a childprop of a null value
    if (object === null && names.length) object = undefined;

    return (object === undefined ? defaultVal : object);
}

export function objectSet(object, path, value, options) {

    let pieces = Array.isArray(path) ? path : path.split('.'), current = object, piece, length = pieces.length;

    if (typeof current !== 'object') {
        throw new Error('Parent is not an object.');
    }

    for (let index = 0; index < length; index++) {
        piece = pieces[index];

        // Create namespace (object) where none exists.
        // If `force === true`, bruteforce the path without throwing errors.
        if (!Object.prototype.hasOwnProperty.call(current, piece) || current[piece] === undefined || (typeof current[piece] !== 'object' && options && options.force === true)) {
            current[piece] = {};
        }

        if (index == (length - 1)) {
            // Set final value
            current[piece] = value;
        } else {
            // We do not overwrite existing path pieces by default
            if (typeof current[piece] !== 'object') {
                throw new Error('Target key "' + piece + '" is not suitable for a nested value. (It is in use as non-object. Set `force` to `true` to override.)');
            }

            // Traverse next in path
            current = current[piece];
        }
    }

    // Is there any case when this is relevant? It's also the last line in the above for-loop
    current[piece] = value;
}

export function objectOnlyEach(obj, array, eachCallback) {
    if(obj == null) return null;

    return array.map((objectKey) => {

        if( typeof  obj[objectKey] != 'undefined' && obj[objectKey] !== '') {
            return eachCallback(obj[objectKey], objectKey);
        }
    });
}

export function objectClone(obj) {
    if (null == obj || "object" != typeof obj) return obj;
    let copy = obj.constructor();
    for (let attr in obj) {
        if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
    }
    return copy;
}

export function deepCopy(obj) {
  if(typeof obj !== 'object' || obj === null) {
    return obj;
  }

  if(obj instanceof Date) {
    return new Date(obj.getTime());
  }

  if(obj instanceof Array) {
    return obj.reduce((arr, item, i) => {
      arr[i] = deepCopy(item);
      return arr;
    }, []);
  }

  if(obj instanceof Object) {
    return Object.keys(obj).reduce((newObj, key) => {
      newObj[key] = deepCopy(obj[key]);
      return newObj;
    }, {});
  }
}
