<?php



$user = wp_get_current_user();
if (!in_array('administrator', (array) $user->roles)) {
    wp_redirect('/');
    exit();
}

if (isset($_POST['data1'])) :
    $_POST = json_decode(file_get_contents("php://input"), true);
    echo $_POST['data1'] ?? '';
    die();
else :
?>

    <head>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        </style>
        <?php wp_head() ?>
    </head>


    <body>
        <div class="antialiased sans-serif bg-gray-200 min-h-screen pt-12">
            <div class="container mx-auto py-6 px-4" x-data="datatables()" x-cloak>
                <div x-show="detailModal.isOpen" id="detailModal" class="fixed w-screen h-screen z-50 inset-0 flex justify-center items-center">
                    <div @click="detailModal.isOpen = false" class="absolute inset-0 bg-black bg-opacity-80"></div>
                    <div class="relative z-10 w-9/12 max-w-screen overflow-auto">
                        <!-- component -->
                        <template x-for="user in users" :key="user.orderId">
                            <form x-show="user.orderId === detailModal.id" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                                <h2 class="text-xl mb-5">Customer Detail</h2>
                                <div class="-mx-3 md:flex">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-first-name" ">
                                        Fullname
                                    </label>
                                    <input 
                                    class=" appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="grid-first-name" type="text" placeholder="Jane" x-model="user.name" disabled>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-last-name">
                                            Phone Number
                                        </label>
                                        <input x-model="user.phone" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-last-name" type="text" placeholder="Doe" disabled>
                                    </div>
                                </div>
                                <div class="-mx-3 md:flex">
                                    <div class="md:w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                                            Address
                                        </label>
                                        <textarea x-text="user.address" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" id="grid-password" disabled></textarea>
                                    </div>
                                </div>
                                <div class="-mx-3 md:flex mb-10">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-city">
                                            City
                                        </label>
                                        <input x-model="user.city" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-city" type="text" placeholder="Albuquerque" disabled>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-zip">
                                            Zip
                                        </label>
                                        <input x-model="user.postalcode" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-zip" type="text" placeholder="90210" disabled>
                                    </div>
                                </div>
                                <h2 class="text-xl mb-5">Payment Detail</h2>
                                <div class="-mx-3 md:flex mb-10">
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                            Payment Amount
                                        </label>
                                        <input x-model="user.paymentAmount" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" type="text" placeholder="90210" disabled>
                                    </div>
                                    <div class="md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                            Payment Type
                                        </label>
                                        <input x-model="user.paymentType" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" type="text" placeholder="90210" disabled>
                                    </div>
                                </div>
                                <div class="-mx-3 md:flex mb-10">
                                    <div class="md:w-1/2 px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                            Payment Type
                                        </label>
                                        <input x-model="user.paymentType" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" type="text" placeholder="" disabled>
                                    </div>
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                                            Payment Status
                                        </label>
                                        <div class="relative">
                                            <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" id="grid-state">
                                                <option>Unpaid</option>
                                                <option>Pending</option>
                                                <option>Paid</option>
                                            </select>
                                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker right-0 inset-y-1/2">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end"><button type="button" class="px-5 py-3 bg-green-500 text-white rounded">Save</button></div>
                            </form>
                        </template>
                    </div>
                </div>
                <h1 class="text-3xl py-4 border-b mb-10">Product Orders</h1>
                <div x-show="selectedRows.length" class="bg-teal-200 fixed top-0 left-0 right-0 z-40 w-full shadow">
                    <div class="container mx-auto px-4 py-4">
                        <div class="flex md:items-center">
                            <div class="mr-4 flex-shrink-0">
                                <svg class="h-8 w-8 text-teal-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div x-html="selectedRows.length + ' rows are selected'" class="text-teal-800 text-lg"></div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 flex justify-between items-center">
                    <div class="flex-1 pr-4">
                        <div class="relative md:w-1/3">
                            <input type="search" class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Search...">
                            <div class="absolute top-0 left-0 inline-flex items-center p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                    <circle cx="10" cy="10" r="7" />
                                    <line x1="21" y1="21" x2="15" y2="15" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="shadow rounded-lg flex">
                            <div class="relative">
                                <button @click.prevent="open = !open" class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                        <path d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                                    </svg>
                                    <span class="hidden md:block">Display</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                        <polyline points="6 9 12 15 18 9" />
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" class="z-40 absolute top-0 right-0 w-40 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                                    <template x-for="heading in headings">
                                        <label class="flex justify-start items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                            <div class="text-teal-600 mr-3">
                                                <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" checked @click="toggleColumn(heading.key)">
                                            </div>
                                            <div class="select-none text-gray-700" x-text="heading.value"></div>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative" style="height: 405px;">
                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                        <thead>
                            <tr class="text-left">
                                <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">
                                    <label class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                        <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" @click="selectAllCheckbox($event);">
                                    </label>
                                </th>
                                <template x-for="heading in headings">
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs" x-text="heading.value" :x-ref="heading.key" :class="{ [heading.key]: true }"></th>
                                </template>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="user in users" :key="user.orderId">
                                <tr class="hover:bg-gray-100 cursor-pointer" @click="handleOpenDetailModal(user.orderId)">
                                    <td class="border-dashed border-t border-gray-200 px-3">
                                        <label class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                            <input type="checkbox" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline" :name="user.orderId" @click="getRowDetail($event, user.orderId)">
                                        </label>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 orders__box userId">
                                        <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.orderId"></span>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 orders__box displayName">
                                        <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.name"></span>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 orders__box paymnentStatus">
                                        <span class="text-gray-700 px-6 py-3 flex items-center">
                                            <span x-bind:class="{
                                        'text-red-500 bg-red-100 rounded-full px-3 py-1' : user.paymentStatus == 'unpaid', 
                                        'text-green-500 bg-green-100 rounded-full px-3 py-1' : user.paymentStatus == 'paid',
                                        'text-yellow-500 bg-yellow-100 rounded-full px-3 py-1' : user.paymentStatus == 'pending'
                                        }" class="text-sm w-20 text-center" x-text="user.paymentStatus"></span>
                                        </span>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 orders__box action">
                                        <span class="text-gray-400 px-6 py-3 flex items-center">tap to view details</span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>



        <script>
            const {
                orders
            } = orders_data;

            console.log(orders)

            document.addEventListener('DOMContentLoaded', (event) => {
                // document.querySelector('#page').classList.add('hidden')
                // document.querySelector('#wpadminbar').classList.add('hidden')
                document.querySelector('style[media="screen"]').innerHTML = ''
                // document.querySelector('.add-to-cart__html-open').classList.add('hidden')
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
        </script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            var params = {
                status: 'paid',
            }

            // axios.post("<?= PLUGIN_URL . 'api/order.php' ?>", params, {
            //     headers: {
            //         'Content-Type': 'application/json'
            //     },
            // }).then((res => console.log(res)));

            axios({
                url: 'http://localhost:8000/graphql',
                method: 'post',
                data: {
                    query: `
                    query MyQuery {
                        orders {
                            nodes {
                            paymentAmount
                            paymentID
                            paymentStatus
                            paymentType
                            }
                        }
                    }
                   `
                }
            }).then((result) => {
                console.log(result.data)
            });
        </script>
    </body>

<?php endif; ?>