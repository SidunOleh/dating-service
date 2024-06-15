import { Modal } from 'ant-design-vue'

function confirmPopup(callback, title) {
    Modal.confirm({
        title: title ?? 'Are you sure?',
        okText: 'Yes',
        cancelText: 'No',
        onOk: callback,
    })
}

function successPopup(title) {
    Modal.success({
        title: title ?? 'Success.',
    })
}

function errorPopup(error) {
    Modal.error({
        title: error ?? 'Error.',
    })
}

export {
    confirmPopup,
    successPopup,
    errorPopup,
}