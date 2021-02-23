const {
    orders
} = orders_data;

document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelector('#page').classList.add('hidden')
    document.querySelector('#wpadminbar').classList.add('hidden')
    document.querySelector('style[media="screen"]').innerHTML = ''
    document.querySelector('.add-to-cart__html-open').classList.add('hidden')
})

const datatables = () => {
    return {
        headings: [{
            'key': 'orderId',
            'value': 'Order ID'
        },
        {
            'key': 'name',
            'value': 'Fullname'
        },
        {
            'key': 'paymentStatus',
            'value': 'Payment Status'
        },
        {
            'key': 'action',
            'value': 'Action'
        },
        ],
        users: orders,
        selectedRows: [],

        open: false,
        detailModal: {
            isOpen: false,
            data: null,
        },

        toggleColumn(key) {
            // Note: All td must have the same class name as the headings key! 
            let columns = document.querySelectorAll('.' + key);

            if (this.$refs[key].classList.contains('hidden') && this.$refs[key].classList.contains(key)) {
                columns.forEach(column => {
                    column.classList.remove('hidden');
                });
            } else {
                columns.forEach(column => {
                    column.classList.add('hidden');
                });
            }
        },

        getRowDetail($event, id) {
            let rows = this.selectedRows;

            if (rows.includes(id)) {
                let index = rows.indexOf(id);
                rows.splice(index, 1);
            } else {
                rows.push(id);
            }
        },

        selectAllCheckbox($event) {
            let columns = document.querySelectorAll('.rowCheckbox');

            this.selectedRows = [];

            if ($event.target.checked == true) {
                columns.forEach(column => {
                    column.checked = true
                    this.selectedRows.push(parseInt(column.name))
                });
            } else {
                columns.forEach(column => {
                    column.checked = false
                });
                this.selectedRows = [];
            }
        },

        handleOpenDetailModal(id) {
            this.detailModal.id = id
            this.detailModal.isOpen = true;
        }
    }
}
