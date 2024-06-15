import store from '../store/store'

function buildIndex(index, parts) {
    if (!parts.length) {
        index[null] = true

        return index
    }

    const part = parts.shift()

    if (!part.match(/,/)) {
        index[part] =
            buildIndex(index[part] ?? [], [...parts])
    } else {
        const subParts = part.split(',')
        for (const subPart of subParts) {
            index[subPart] =
                buildIndex(index[subPart] ?? [], [...parts])
        }
    }

    return index
}

function checkIndex(permission, index) {
    if (index[null] !== undefined) {
        return true
    }

    if (!permission.length) {
        return false
    }

    const first = permission.shift()

    if (
        index[first] !== undefined &&
        checkIndex(permission, index[first])
    ) {
        return true
    }

    if (index['*'] !== undefined) {
        return checkIndex(permission, index['*'])
    }

    return false
}

function can(permissions) {
    if (!store.getters.logged) {
        return false
    }

    let index = []

    for (const userPermission of store.getters.user.permissions ?? []) {
        index = buildIndex(index, userPermission.split('.'))
    }

    if (typeof permissions == 'string') {
        return checkIndex(permissions.split('.'), index)
    }

    for (const permission of permissions) {
        if (checkIndex(permission.split('.'), index)) {
            return true
        }
    }

    return false
}

export default can