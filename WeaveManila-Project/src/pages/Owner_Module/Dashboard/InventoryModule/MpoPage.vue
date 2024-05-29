<template>
<SideBar />
<q-page class="bg-[#f5f5f5] ">
  <div class='flex justify-between items-center text-[30px] bg-white p-2'>
    <div>
      <div class="items-center flex">
        <q-icon
          name="menu"
          v-if="showMenuIcon"
          @click="toggleDrawer"
          class="cursor-pointer"
        />
        <q-icon
          name="menu"
          v-if="!showMenuIcon"
          @click="toggleDrawer"
          class="cursor-pointer max-[1020px]:flex min-[1020px]:hidden"
        />
        <span class="font-bold">Purchase List</span>
      </div>
      <div class="text-[16px]"><span class="text-[#b8b8b8]">Inventory / </span>Purchase List</div>
    </div>
    <LogoutTop />
  </div>

  <div class="p-4">
    <div class="w-full bg-white p-4 h-[500px]">
      <div class="flex md:items-end md:justify-between">
          <div class="flex items-center gap-2">
            <q-input outlined dense placeholder="Search" class="md:w-[200px]">
              <template v-slot:prepend>
                <q-icon name="search" />
              </template>
            </q-input>
            <div class='flex items-center gap-2'>
              Status
              <div class='flex'>
                <q-btn label='Pending' size='md' :style="{ backgroundColor: statuss === 'pending' ? '#967259' : '#ffffff', color: statuss === 'pending' ? 'white' : 'black' }" @click="setStatus('pending')"/>
                <q-btn label='Partial Received' size='md' :style="{ backgroundColor: statuss === 'partialReceived' ? '#967259' : '#ffffff', color: statuss === 'partialReceived' ? 'white' : 'black' }" @click="setStatus('partialReceived')"/>
                <q-btn label='Received' size='md' :style="{ backgroundColor: statuss === 'received' ? '#967259' : '#ffffff', color: statuss === 'received' ? 'white' : 'black' }" @click="setStatus('received')"/>

              </div>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <q-btn-dropdown square icon="download">
              <q-list>
                <q-item clickable v-close-popup >
                  <q-item-section>
                    <q-item-label>Excel</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable v-close-popup>
                  <q-item-section>
                    <q-item-label>PDF</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
            <q-btn square icon="print"/>
            <q-btn label="Add MPO" icon='add' class='bg-[#281C0F] text-white'  @click="fullHeight = true"/>


            <q-dialog
              v-model="fullHeight"
              full-height
              full-width
            >
              <q-card class="column full-height" style="width: 300px">
                <q-card-section class="row items-center q-pb-none">
                  <div class="text-h6">MPO Form</div>
                  <q-space />
                  <q-btn icon="close" flat round dense v-close-popup />
                </q-card-section>

                <q-card-section class="col q-pt-none">
                  <MPOForm />
                </q-card-section>
              </q-card>
            </q-dialog>
            <!-- <q-btn-dropdown label="Category">
              <q-list>
                <q-item @click="onItemClick(null)">
                  <q-item-label class='cursor-pointer' >All Categories</q-item-label>
                </q-item>
                <q-item v-for="(category, index) in categories" :key="index" >
                  <q-item-label class='cursor-pointer' @click="onItemClick(category.categoryID)">{{ category.title }}</q-item-label>
                </q-item>
              </q-list>
            </q-btn-dropdown> -->
          </div>
        </div>
      <div class="q-pa-md">
        <q-table
            :rows="rows"
            :columns="columns"
            row-key="mpo_id"
            class="my-sticky-header-table"
            :dense="$q.screen.lt.md"
            flat bordered
          >
          <template v-slot:body-cell-product="props">
            <q-td :props="props">
              <div v-if="props.row.product && props.row.product.length > 0">
                <!-- Iterate over each product -->
                <div v-for="(product, index) in props.row.product" :key="index">
                  <div v-if="product !== null">
                    <!-- Expand icon -->
                    <!-- <q-icon  name="expand_more" @click="toggleExpand(props.row.mpo_id, product)" /> -->
                    {{ product }}
                  </div>

                  <!-- Expanded details -->
                  <div v-if="isExpanded(props.row.mpo_id, product)">
                    <!-- Additional text to show when expanded -->
                    More details for {{ product }} here...
                  </div>
                </div>
              </div>
            </q-td>
          </template>

        <template v-slot:body-cell-qty="props">
          <q-td :props="props">
            <div v-for="qty in props.row.qty" :key="qty">{{ qty }}</div>
          </q-td>
        </template>

        <template v-slot:body-cell-qty_received="props">
          <q-td :props="props">
            <div v-for="qty_received in props.row.qty_received" :key="qty_received">{{ qty_received }}</div>
          </q-td>
        </template>

      <template v-slot:body-cell-date_received="props">
        <q-td :props="props">
          <!-- <div v-for="product in props.row.product" :key="product"> -->
            <div v-for="(date_received, dateIndex) in props.row.date_received" :key="dateIndex" :class="{ 'cursor-pointer': isValidDate(date_received) }" @click="handleDateClick(date_received, props.row.mpo_id, props.row, dateIndex)">
              {{ date_received }}
              <q-tooltip v-if="isValidDate(date_received)" :offset="[0, 8]">View More</q-tooltip>
            </div>

          <!-- </div> -->
        </q-td>
      </template>


        <template v-slot:body-cell-status="props">
          <q-td :props="props">
            <div v-for="status in props.row.status" :key="status">
              <q-badge :color="calculateStatus(status)">
                {{ status }}
              </q-badge>
            </div>
          </q-td>
        </template>

        <template v-slot:body-cell-amount="props">
          <q-td :props="props">
            <div v-for="amount in props.row.amount" :key="amount">{{ amount }}</div>
          </q-td>
        </template>

        <template v-slot:body-cell-actions="props">
              <q-td :props="props">
                <div class="flex items-center justify-center w-[221px] gap-1">
                  <div @click="ProductReceived(props.row.mpo_id)" class="bg-[#ddffcd] py-1 px-2 text-green-600 rounded font-bold cursor-pointer">
                    Received

                  </div>

                  <div class="bg-[#26218e] rounded text-white cursor-pointer w-[32px] h-[32px] text-[20px]">
                    <q-icon name="assignment" @click="ViewForm(props.row.mpo_id)">
                      <q-tooltip :offset="[0, 8]">View Form</q-tooltip>
                    </q-icon>
                  </div>
                  <div class="bg-[#475467] rounded text-white cursor-pointer w-[32px] h-[32px] text-[20px]">
                    <q-icon name="edit" @click="toNextPage(props.row.mpo_id)">
                      <q-tooltip :offset="[0, 8]">Edit</q-tooltip>
                    </q-icon>
                  </div>
                  <!-- <div class="w-[32px] h-[32px] cursor-pointer text-[20px]">
                    <q-icon name="arrow_forward_ios" @click="toNextPage(props.row.mpo_id)"/>
                  </div> -->
                </div>
              </q-td>
        </template>
        </q-table>
      </div>
    </div>
  </div>

  <q-dialog
      v-model="medium"
    >
      <q-card style="width: 500px; max-width: 80vw;">
        <q-card-section class="row q-pb-none">
          <div class="gap-2 text-h6 items-center flex">
            <q-icon name='local_mall' class='p-2 border me-2 rounded'/>
            <div>
              <p class='font-bold'>{{ mpoProductName.charAt(0).toUpperCase() + mpoProductName.slice(1) }}</p>
              <p class='text-[15px] -mt-4'>MPO {{ mposelectedID }}</p>
            </div>
          </div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-separator class='mb-3'/>
        <q-card-section class="q-pt-none">
          <q-input class='mb-3 hidden' disabled v-model="searchQuery" label="Search..." dense outlined>
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-input>
          <div class='mb-3'>
            <p class='text-[16px]'><span class='font-bold'>Quantity Purchased: </span>{{ qtyReceived }}</p>
          </div>
          <q-table
            style="height: 400px"
            flat bordered
            separator="cell"
            :rows="filteredRows"
            :columns="datecolumns"
            row-key="index"
            virtual-scroll
            v-model:pagination="pagination"
            :rows-per-page-options="[0]"
          >
            <template v-slot:body-cell-status="props">
              <q-td :props="props">
                <span v-if="props.row.status === 'Received'" class="bg-green-500 text-white p-1 text-center rounded">{{ props.row.status }}</span>
                <span v-else-if="props.row.status === 'Partial Received'" class="bg-yellow-500 text-white text-center rounded p-1">{{ props.row.status }}</span>
                <span v-else class="bg-red-500 text-white text-center rounded">{{ props.row.status }}</span>
              </q-td>
            </template>
          </q-table>

        </q-card-section>

      </q-card>
    </q-dialog>
<!-- MODAL FORM -->
<q-dialog
    v-model="previewForm"
    full-width
    full-height
    >
      <q-card>
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6 flex items-center">
            <q-icon name="assignment_add" class="w-[48px] h-[48px]"/>
            MPO {{ MpoIDValue }}
          </div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>
        <q-card-section>
          <div class="flex items-end justify-end gap-2">
            <q-btn icon="download" @click="generatePDF"/>
            <q-btn icon="print" @click="printContent"/>
            <q-btn label="Send to email" icon="send" class="bg-[#634842] text-white" @click="generatePDFAndSendEmail"/>
          </div>
        </q-card-section>
        <q-card-section class="overflow-y-auto overflow-x-hidden h-[460px] flex justify-center items-center">
          <div class="border-[#634832] border">
            <div id="content" class="p-5 w-[936px] ">
              <div class="flex">
                <div class="w-1/2">
                    <div class="p-10 text-center">
                        <q-img
                          :src="getCompanyImagePath()"
                          alt="Description of the image"
                          class="w-[250px] h-[250px]"
                        />
                        <p class="text-[14px] mt-8">{{ company_address }}</p>
                    </div>
                </div>
                <div class="w-1/2  p-10 flex justify-center items-center">
                    <div class="w-[410px] ">
                        <div class="text-h5 font-bold text-center text-[#634832]">MATERIAL PURCHASE ORDER</div>
                        <div class="mt-4">
                            <div class="grid grid-cols-2 ">
                                <div class="p-2">Date Purchase</div>
                                <div class="border-[#634832] border p-2 text-center font-bold">{{ date_purchased }}</div>
                            </div>
                            <div class="grid grid-cols-2 ">
                                <div class="p-2">MPO NO.</div>
                                <div class="border-[#634832] border p-2 text-center font-bold">{{ mpo_ref }}</div>
                            </div>
                            <div class="grid grid-cols-2 ">
                                <div class="p-2">CLIENT REFERENCE NO.</div>
                                <div class="border-[#634832] border p-2 text-center font-bold">{{ client_ref }}</div>
                            </div>
                            <div class="grid grid-cols-2 ">
                                <div class="p-2">W.O REFERENCE NO.</div>
                                <div class="border-[#634832] border p-2 text-center font-bold">{{ wo_purchased }}</div>
                            </div>
                            <div class="grid grid-cols-2 ">
                                <div class="p-2">DELIVERY DATE</div>
                                <div class="border-[#634832] border p-2 text-center font-bold">{{ delivery_date_val }}</div>
                            </div>
                            <div class="grid grid-cols-2 ">
                                <div class="p-2">DELIVERY ADDRESS</div>
                                <div class="border-[#634832] border p-2 text-center font-bold">{{ delivery_add_val }}</div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class='flex'>
                <div class='w-1/2 p-4'>
                  <p class='font-bold text-[16px]'>TO</p>
                  <p>{{ selectedSupplier }}</p>
                  <p class='font-italic'>{{ supplier_address }}</p>
                </div>
                <div class='w-1/2 p-4'>
                  <p class='font-bold text-[16px]'>Services</p>
                  <p>
                    {{ listService }}
                  </p>
                </div>
              </div>
              <div class="w-full p-2 flex justify-center items-center mt-6">
                <table class="w-full">
                  <thead class="bg-[#f6f8fa] text-left">
                    <tr>
                      <th class="px-4 py-2 ">ID</th>
                      <th class="px-4 py-2">Product</th>
                      <th class="px-4 py-2">Description</th>
                      <th class="px-4 py-2">Quantity</th>
                      <th class="px-4 py-2">Unit</th>
                      <th class="px-4 py-2">Unit Price</th>
                      <th class="px-4 py-2">Sub Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(row, index) in datarows" :key="index">
                      <td class="px-4 py-2">{{ index + 1 }}</td>
                      <td class="px-4 py-2">{{ row.sproduct }}</td>
                      <td class="px-4 py-2">{{ row.sdescription }}</td>
                      <td class="px-4 py-2">{{ row.squantity }}</td>
                      <td class="px-4 py-2">{{ row.sunit }}</td>
                      <td class="px-4 py-2">₱{{ row.sunitprice }}</td>
                      <td class="px-4 py-2">₱{{ row.stotal }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="w-full p-2 flex items-center">
                <div class="w-1/2">
                  <div class="border bg-[#f6f8fa] p-2 w-[500px]">
                    Notes & Instructions
                  </div>
                  <div class="w-[500px] whitespace-pre-line h-[200px] border p-2">
                    {{ notes_instructions }}
                  </div>
                </div>
                <div class="w-1/2 flex justify-end">
                  <div class='grid grid-cols-2 w-[253px] text-[16px] gap-2'>
                    <div class="font-bold">Delivery Charge</div>
                    <div>₱ {{ deliver_charge }}</div>
                    <div class="font-bold">Other Costs</div>
                    <div>₱ {{ other_cost }}</div>
                    <div class="font-bold">Sub Total</div>
                    <div>₱ {{ total_in_table }}</div>
                    <div class="font-bold">Discount</div>
                    <div>% {{ discount }}</div>
                    <div class="font-bold">TAX/VAT</div>
                    <div>% {{ vat }}</div>
                    <div class="font-bold">Total Amount</div>
                    <div>₱ {{ total_amount }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </q-card-section>
      </q-card>
</q-dialog>

<!-- PRODUCT RECIEVED -->
<q-dialog v-model="product_dialog">
  <q-card style="width: 1024px; max-width: 80vw;">
    <q-card-section class="row items-center q-pb-none">
      <div class="flex items-center gap-2">
        <div class='p-2 text-[18px] border '>
          <q-icon name="local_mall"/>
        </div>
        <span class="font-semibold text-[18px]">Product Received</span>
      </div>
      <q-space />
      <q-btn icon="close" flat round dense v-close-popup />
    </q-card-section>

    <q-card-section class="text-[18px]">
      <div class='grid grid-cols-2 gap-10'>
        <div>
          <label>MPO Ref. No</label>
          <q-input dense outlined disable v-model="mpo_ref"/>
        </div>
        <div>
          <label>Date Received</label>
          <q-input dense outlined v-model="date_received" type='date' required/>
        </div>
      </div>
      <q-table
        dense bordered
        :rows="selectedRows"
        :columns="selectedColumns"
        row-key="name"
        class="my-sticky-header-table-second mt-3"
      >
      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="id" :props="props">
            {{ props.row.id }}
          </q-td>

          <q-td key="sproducts" :props="props">
            {{ props.row.sproducts }}
          </q-td>

          <q-td key="sdescription" :props="props">
            {{ props.row.sdescription }}
          </q-td>

          <q-td key="sqtypurchased" :props="props">
            {{ props.row.sqtypurchased }}
          </q-td>

          <q-td key="sunit" :props="props">
            {{ props.row.sunit }}
          </q-td>

          <q-td key="sqtyrecieved" :props="props">
            {{ props.row.sqtyrecieved }}
          </q-td>

          <q-td key="sreceived" :props="props">
            {{ props.row.sreceived }}
            <q-popup-edit v-model="props.row.sreceived" title="Update Description" :disable="props.row.sstatus === 2" buttons v-slot="scope">
              <q-input type="number" v-model="scope.value" dense autofocus />
            </q-popup-edit>
          </q-td>



          <q-td key="sstatus" :props="props">
            <q-badge :color="calculateStatusColor(props.row.sstatus)">
              {{ getStatusWord(props.row.sstatus) }}
            </q-badge>
          </q-td>
        </q-tr>
      </template>
      <!-- <template v-slot:body-cell-sstatus="props">
        <q-badge :color="calculateStatusColor(props.row.sstatus)">
          {{ getStatusWord(props.row.sstatus) }}
        </q-badge>
      </template> -->
      </q-table>
    </q-card-section>
    <q-card-actions align="right">
      <q-btn @click="submitHandler" class="bg-[#634832] text-white" label="Submit" />
    </q-card-actions>
  </q-card>
</q-dialog>
</q-page>
<q-dialog v-model="OpenLogout">
  <q-card class="w-[500px]">
    <q-card-section class="gap-3 items-center q-pb-none flex">
      <div class="py-1 px-2 border text-[24px]"><q-icon name="logout"/></div>
      <div class="text-h6 font-bold">Logout</div>
      <q-space />
    </q-card-section>

    <q-card-section>

      <p>Are you sure you want to Logout?</p>
    </q-card-section>

    <q-card-actions class="flex justify-center items-center">
      <div class="w-1/2 p-1">
        <q-btn flat label="Cancel" outline v-close-popup class="w-full border"/>
      </div>
      <div class="w-1/2 p-1">
        <q-btn
          @click="logout"
          flat
          label="Logout"
          size="md"
          class="bg-red-600 text-white rounded w-full"
        />
      </div>
    </q-card-actions>
  </q-card>
</q-dialog>

</template>

<script>
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import SideBar from '../Essentials/SideBar.vue';
import LogoutTop from '../Essentials/LogoutTop.vue';
import MPOForm from './MpoForm.vue';
export default {
  components: {
    SideBar,
    LogoutTop,
    MPOForm,
  },
  data() {
    return {
      fullHeight: false,
      searchQuery: '',
      pagination: {
        page: 1,
        rowsPerPage: 10
      },
      medium: false,
      isAdmin: 0,
      email: '',
      fullname: '',
      firstname: '',
      middlename: '',
      lastname: '',
      userProfileImage: null,
      username: '',
      position: '',
      status: '',
      drawer: false,
      showMenuIcon: false,
      statusCheckTimer: null,
      toggleDrawers: true,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      // Additional Data
      mposelectedID: '',
      mpoProductName: '',
      qtyReceived: '',
      firstStep: false,
      secondStep: false,
      datecolumns: [
        { name: 'qty_received', align: 'left', label: 'Quantity Received', field: 'qty_received', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'date', align: 'left', label: 'Date', field: 'date', sortable: true, headerStyle: 'width: 100px;' },
      ],
      daterows: [],
      columns: [
        { name: 'mpo_number', align: 'left', label: 'MPO No.', field: 'mpo_number', sortable: true, headerStyle: 'width: 44px;' },
        { name: 'supplier', align: 'left', label: 'Supplier', field: 'supplier', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'product', align: 'left', label: 'Product', field: 'product', sortable: true, headerStyle: 'width: 150px;' },
        { name: 'qty', align: 'left', label: 'Qty Purchased', field: 'qty', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'qty_received', align: 'left', label: 'Qty Received', field: 'qty_received', sortable: true, headerStyle: 'width: 120px;' },
        { name: 'date_received', align: 'left', label: 'Date Received', field: 'date_received', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'actions', align: 'center', label: 'Actions', field: 'actions', sortable: true },
      ],

      rows: [],
      selected: [],
      previewForm: false,
      product_dialog: false,
      // Second Process Data
      expandedProducts: [],
      company_address: '',
      listService: '',
      uploadPhoto: '',
      mpo_ref: '',
      date_purchased: '',
      selectedCategory: '',
      client_ref: '',
      wo_purchased: '',
      delivery_date_val: '',
      delivery_add_val: '',
      selectedSupplier: '',
      supplier_address: '',
      segregation: '',
      cleaning: '',
      drying: '',
      weighting: '',
      deliver_charge: '',
      discount: '',
      vat: '',
      other_cost: '',
      total_amount: '',
      total_in_table: '',
      notes_instructions: '',
      prepared_name: '',
      approvedby_name: '',
      e_signatureP: '',
      e_signatureA: '',
      MpoIDValue: '',
      OpenLogout: false,
      selectedColumns: [
        { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true },
        { name: 'sproducts', align: 'left', label: 'Product', field: 'sproducts', sortable: true },
        { name: 'sdescription', align: 'left', label: 'Description', field: 'sdescription', sortable: true },
        { name: 'sqtypurchased', align: 'left', label: 'Quantity Purchased', field: 'sqtypurchased', sortable: true },
        { name: 'sunit', align: 'left', label: 'Unit', field: 'sunit', sortable: true },
        { name: 'sqtyrecieved', align: 'center', label: 'Quantity Received', field: 'sqtyrecieved', sortable: true },
        { name: 'sreceived', align: 'left', label: 'Received', field: 'sreceived', sortable: true },
        // { name: 'sstatus', align: 'left', label: 'Status', field: 'sstatus', sortable: true },
      ],
      selectedRows: [],
      date_received: '',
      categories: [],
      statuss: 'pending',
    };
  },
  // watch: {
  //   selectedRows: {
  //     handler(newRows, oldRows) {
  //       newRows.forEach(row => {
  //         // Check if received quantity equals or exceeds purchased quantity
  //         if (row.sreceived == row.sqtypurchased) {
  //           row.sstatus = 2; // Set status to 2 if received quantity equals purchased quantity
  //         } else if (row.sreceived === 0 || row.sreceived === '0') {
  //           row.sstatus = 0;
  //         } else if (row.sreceived < row.sqtypurchased) { // Check if received quantity is lower than purchased quantity
  //           row.sstatus = 1; // Set status to 1 if received quantity is lower than purchased quantity
  //         } else { // Default case: received quantity is higher than purchased quantity or invalid
  //           row.sstatus = 0; // Set status to 0
  //         }
  //       });
  //       const invalidRows = newRows.filter(row => row.sreceived > row.sqtypurchased);
  //       if (invalidRows.length > 0) {
  //         invalidRows.forEach(row => {
  //           row.sreceived = 0;
  //         });
  //         this.$q.notify({
  //           type: 'negative',
  //           message: 'Received quantity cannot exceed purchased quantity in some rows.'
  //         });
  //       }
  //     },
  //     deep: true
  //   }
  // },
  computed: {
    filteredRows() {
      if (!this.searchQuery) return this.daterows;
      const query = this.searchQuery.toLowerCase();
      return this.daterows.filter(row =>
        Object.values(row).some(val => {
          if (typeof val === 'string') {
            return val.toLowerCase().includes(query);
          }
          return false;
        })
      );
    }
  },
  mounted() {
    this.fetchImageLogo();
    this.fetchCategory();
    this.loadUserData();
    this.fetchMPOData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    setStatus(newStatus) {
      this.statuss = newStatus;
      console.log(this.statuss)
      let select = 0;
      if (newStatus === 'received') {
        select = 2;
      }
      if (newStatus === 'partialReceived') {
        select = 1;
      }
      if (newStatus === 'pending') {
        select = 0;
      }
      axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=alldata&id=${select}`)
      .then(response => {

        try {
            const groupedData = response.data.categoryData.reduce((acc, row) => {
              if (!acc[row.mpoID]) {
                  acc[row.mpoID] = {
                      mpo_id: row.mpoID,
                      mpo_number: row.mpoID,
                      supplier: row.supplier_name,
                      date_purchase: row.date_purchased,
                      handler_received: [],
                      product: [],
                      qty: [],
                      total: [],
                      amount: [],
                      status: [],
                      qty_received: [],
                      date_received: [],
                  };
              }
              acc[row.mpoID].handler_received.push(row.handler_received);
              acc[row.mpoID].amount.push(row.subtotal);
              acc[row.mpoID].product.push(row.item_name);
              acc[row.mpoID].qty.push(row.quantity);
              const time = new Date(row.date_received).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

              acc[row.mpoID].date_received.push(time);


              acc[row.mpoID].qty_received.push(row.quantity_received);

              // Calculate status based on received quantity
              let status = '';
              if (row.quantity_received === row.quantity) {
                  status = '● Received';
              } else if (!row.quantity_received || row.quantity_received === '0') {
                status = '● Pending';
              } else if (row.quantity_received < row.quantity) {
                  status = '● Partial Received';
              }
              acc[row.mpoID].status.push(status);
              return acc;
          }, {});
          console.log('Test: ',groupedData)
          const groupedArray = Object.values(groupedData);

          // Filter out ungrouped data (where only one data point exists)
          const ungroupedData = response.data.categoryData.filter(row => !groupedData[row.mpoID]);

          // Combine grouped and ungrouped data
          const combinedData = groupedArray.concat(ungroupedData);

          this.rows = combinedData;
        }catch{
          this.rows = [];
        }

      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
    },
    onItemClick(category) {
      if (!category) {
        this.fetchMPOData();
      } else {
        axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=targetCategory&id=${category}`)
        .then(response => {
          try {
            const groupedData = response.data.categoryData.reduce((acc, row) => {
                if (!acc[row.mpoID]) {
                    acc[row.mpoID] = {
                        mpo_id: row.mpoID,
                        mpo_number: row.mpoID,
                        supplier: row.supplier_name,
                        date_purchase: row.date_purchased,
                        product: [],
                        qty: [],
                        total: [],
                        amount: [],
                        status: [],
                        qty_received: [],
                        date_received: [],
                    };
                }
                acc[row.mpoID].amount.push(row.subtotal);
                acc[row.mpoID].product.push(row.item_name);
                acc[row.mpoID].qty.push(row.quantity);
                // Check if date_received is null
                const time = new Date(row.date_received).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                if (row.date_received !== null) {
                  acc[row.mpoID].date_received.push(time);
                } else {
                  acc[row.mpoID].date_received.push(''); // Pushing an empty string for null values
                }

                acc[row.mpoID].qty_received.push(row.quantity_received);

                // Calculate status based on received quantity
                let status = '';
                if (row.quantity_received === row.quantity) {
                    status = '● Received';
                } else if (!row.quantity_received || row.quantity_received === '0') {
                  status = '● Pending';
                } else if (row.quantity_received < row.quantity) {
                    status = '● Partial Received';
                }
                acc[row.mpoID].status.push(status);
                return acc;
            }, {});

            const groupedArray = Object.values(groupedData);

            // Filter out ungrouped data (where only one data point exists)
            const ungroupedData = response.data.categoryData.filter(row => !groupedData[row.mpoID]);

            // Combine grouped and ungrouped data
            const combinedData = groupedArray.concat(ungroupedData);

            this.rows = combinedData;
          } catch (error) {
            console.error('Error processing data:', error);
            this.$q.notify({
              color: 'negative',
              position: 'bottom',
              message: 'There is no data in this category.',
            });
          }
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
      }
    },
    getCompanyImagePath() {
      // Ensure userProfileImage is not null before creating the path
      if (this.companyimage) {
        return `/Logo/${this.companyimage}`;
      }else if (this.companyimage == '') {
        // Return a default path or handle it as per your requirement
        return '/Logo/default_logo.png';
      }
      else {
        // Return a default path or handle it as per your requirement
        return '/Logo/default_logo.png';
      }
    },
    fetchImageLogo(){
      axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=companylogo`)
      .then(response => {
          this.companyimage = response.data.isAdmin.company_logo;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    fetchCategory() {
      axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=category`)
        .then(response => {
          // Assuming response.data is an array of categories
          this.categories = response.data.categoryData;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    handleDateClick(date_received, event, product, dateIndex) {
      const a = dateIndex;
      if (this.isValidDate(date_received)) {
        axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=datelogs&id=${event}`)
        .then(response => {
          this.medium = true;
          console.log(response.data)
          this.daterows = response.data.dateLogs[0].map((row, index) => {
            const timestamp = new Date(row.timestamp_column);
            let statusLabel = '';
            switch (row.status) {
              case 2:
                statusLabel = 'Received';
                break;
              case 1:
                statusLabel = 'Partial Received';
                break;
              case 0:
                statusLabel = 'Pending';
                break;
              default:
                statusLabel = '';
            }
            const time = new Date(row.date_received).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

            return {
              // index: index + 1,
              product: row.item_name,
              date: time,
              qty_received: row.received,
              // status: statusLabel // in status 2 = Recieved 1 = Partial Received and 0 for Pending
            };
          });
          this.searchQuery = product.product[a];
          this.mpoProductName = product.product[a];
          this.qtyReceived = product.qty_received[a];
          this.mposelectedID = product.mpo_id;
        }).catch(error => {
          console.error('Error fetching data:', error);
        });
      } else {
        console.log('No Data clicked, cannot proceed.');
      }
    },
    isValidDate(dateString) {
      // Attempt to create a Date object from the dateString
      const date = new Date(dateString);
      // Check if the date object is valid
      // If it's an invalid date or "No Data", return false
      return !isNaN(date.getTime()) && dateString !== 'No Data';
    },
    toNextPage(targetID) {
      axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/mpopage_segregation.php?select=${targetID}`)
          .then(response => {
              const Status = response.data.status;
              const Message = response.data.message;
              const itemId = response.data.mpoBaseFetch;
              const mpoData = response.data.queryResult;

              if (Status === "success") {
                  this.$q.notify({
                      message: `${Message}`,
                      color: 'green',
                  });
                  if (Array.isArray(itemId)) {
                    mpoData.map(mpoInfo => {
                      const mpoDataRestrieve = {
                          mpoID: mpoInfo.mpoID,
                          personelID: mpoInfo.personelID,
                          supplierID: mpoInfo.supplierID,
                          categoryID: mpoInfo.categoryID,
                          mpo_ref_no: mpoInfo.mpo_ref_no,
                          date_purchased: mpoInfo.date_purchased,
                          client_ref_no: mpoInfo.client_ref_no,
                          w_o_ref_no: mpoInfo.w_o_ref_no,
                          delivery_date: mpoInfo.delivery_date,
                          delivery_address: mpoInfo.delivery_address,
                          supplier_address: mpoInfo.supplier_address,
                          total: mpoInfo.total,
                          delivery_charge: mpoInfo.delivery_charge,
                          discount: mpoInfo.discount,
                          other_costs: mpoInfo.other_costs,
                          total_amount: mpoInfo.total_amount,
                          notes_instructions: mpoInfo.notes_instructions,
                          prepared_by: mpoInfo.prepared_by,
                          approved_by: mpoInfo.approved_by,
                          supplier_name: mpoInfo.supplier_name,
                      };
                      SessionStorage.set('MPOData', JSON.stringify(mpoDataRestrieve));
                    });


                    this.$router.push('/dashboard/rawmaterials-section');
                } else {
                    console.error('itemId is not an array.');
                }
              }
              if (Status === "fail") {
                  this.$q.notify({
                      color: 'negative',
                      message: `${Message} Please try again.`,
                  });
              }
          }).catch(error => {
              console.error('Error fetching data:', error);
          });
    },

    toggleExpand(mpoId, product) {

      const key = `${mpoId}_${product}`;
      if (this.expandedProducts.includes(key)) {
        console.log(`Collapsing ${product} in row with mpo_id ${mpoId}`);
        this.expandedProducts = this.expandedProducts.filter(p => p !== key);
      } else {
        console.log(`Expanding ${product} in row with mpo_id ${mpoId}`);
        this.expandedProducts.push(key);
      }
    },
    isExpanded(mpoId, product) {
      // Check if the product in the specified row is expanded
      const key = `${mpoId}_${product}`;
      return this.expandedProducts.includes(key);
    },
    generatePDFAndSendEmail() {
      const pdf = new jsPDF();
      const content = document.getElementById('content');

      // Use html2canvas to render HTML to canvas
      html2canvas(content).then(canvas => {
        // Convert canvas to base64 image data
        const imgData = canvas.toDataURL('image/jpeg');

        const pageWidth = 215.9; // A4 width in mm
        const pageHeight = 355.6; // A4 height in mm

        const imgWidth = pageWidth;
        const imgHeight = (canvas.height * pageWidth) / canvas.width;

        let position = 0;
        if (imgHeight > pageHeight) {
          pdf.addPage();
          position = -pageHeight;
          pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
        } else {
          pdf.addImage(imgData, 'JPEG', 0, 0, imgWidth, imgHeight);
        }

        while (position + pageHeight < imgHeight) {
          position += pageHeight;
          pdf.addPage();
          pdf.addImage(imgData, 'JPEG', 0, -position, imgWidth, imgHeight);
        }

        // Convert the PDF to Blob
        const pdfBlob = pdf.output('blob');

        const pdfformat = `MPO${this.MpoIDValue}-form.pdf`;
        const formData = new FormData();
        formData.append('pdfFile', pdfBlob, pdfformat);
        formData.append('pdfFileName', pdfBlob, pdfformat);
        formData.append('selectedSupplier', this.selectedSupplier);
        // Send the FormData via email using Axios
        axios.post('https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/viewform.php/', formData)
          .then(response => {
            const Status = response.data.status;
            const Message = response.data.message;
            if (Status === "fail") {
              this.$q.notify({
                color: 'negative',
                message: `${Message} Please try again.`,
              });
              this.previewForm = false;
            }
            if (Status === "success") {
              this.$q.notify({
                color: 'green',
                message: `The MPO ${this.MpoIDValue} form has been successfully sent to the supplier's email..`,
              });
              this.previewForm = false;
            }
          })
          .catch(error => {
            console.error('Error sending PDF:', error);
            // Handle error, show error message, etc.
          });
      });
    },
    generatePDF() {
      const pdf = new jsPDF();
      const content = document.getElementById('content');

      // Use html2canvas to render HTML to canvas
      html2canvas(content).then(canvas => {
        // Convert canvas to base64 image data
        const imgData = canvas.toDataURL('image/jpeg');

        const pageWidth = 215.9; // A4 width in mm
        const pageHeight = 355.6; // A4 height in mm

        const imgWidth = pageWidth;
        const imgHeight = (canvas.height * pageWidth) / canvas.width;


        let position = 0;
        if (imgHeight > pageHeight) {

          pdf.addPage();
          position = -pageHeight;

          pdf.addImage(imgData, 'JPEG', 0, position, imgWidth, imgHeight);
        } else {
          pdf.addImage(imgData, 'JPEG', 0, 0, imgWidth, imgHeight);
        }

        while (position + pageHeight < imgHeight) {
          position += pageHeight;
          pdf.addPage();
          pdf.addImage(imgData, 'JPEG', 0, -position, imgWidth, imgHeight);
        }

        // Save PDF
        const pdfformat = `MPO${this.MpoIDValue}-form.pdf`;
        pdf.save(pdfformat);

        // this.pdfData = pdf.output('blob');
        // console.log("PDF Data",this.pdfData);
      });
    },
    printContent() {
      this.previewForm = false;
      const printableContent = document.getElementById('content');
      const originalContents = document.body.innerHTML;
      document.body.innerHTML = printableContent.innerHTML;
      window.print();
      document.body.innerHTML = originalContents;
      window.addEventListener('afterprint', this.reloadPage);
      this.reloadPage();
    },
    reloadPage() {
      window.removeEventListener('afterprint', this.reloadPage);
      location.reload();
    },

    refreshData(){
      this.fetchMPOData();
    },
    fetchMPOData() {
      let select = 0;
      axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=alldata&id=${select}`)
      .then(response => {
        console.log(response.data)
        const groupedData = response.data.categoryData.reduce((acc, row) => {
          const times = new Date(row.date_purchased).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            if (!acc[row.mpoID]) {
                acc[row.mpoID] = {
                    mpo_id: row.mpoID,
                    mpo_number: row.mpoID,
                    supplier: row.supplier_name,
                    date_purchase: times,
                    product: [],
                    qty: [],
                    total: [],
                    amount: [],
                    status: [],
                    qty_received: [],
                    date_received: [],
                };
            }
            acc[row.mpoID].amount.push(row.subtotal);
            acc[row.mpoID].product.push(row.item_name);
            acc[row.mpoID].qty.push(row.quantity);
            const time = new Date(row.date_received).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

            acc[row.mpoID].date_received.push(time);


            acc[row.mpoID].qty_received.push(row.quantity_received);

            // Calculate status based on received quantity
            let status = '';
            if (row.quantity_received === row.quantity) {
                status = '● Received';
            } else if (!row.quantity_received || row.quantity_received === '0') {
              status = '● Pending';
            } else if (row.quantity_received < row.quantity) {
                status = '● Partial Received';
            }
            acc[row.mpoID].status.push(status);
            return acc;
        }, {});

        const groupedArray = Object.values(groupedData);

        // Filter out ungrouped data (where only one data point exists)
        const ungroupedData = response.data.categoryData.filter(row => !groupedData[row.mpoID]);

        // Combine grouped and ungrouped data
        const combinedData = groupedArray.concat(ungroupedData);

        this.rows = combinedData;
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
    },


    calculateStatus(status) {
      switch (status) {
        case '● Pending':
          return 'red';
        case '● Partial Received':
          return 'yellow';
        case '● Received':
          return 'green';
        default:
          return 'gray'
      }
    },
    handleCheckboxChange(rowId) {
      const index = this.selected.indexOf(rowId);

      if (index === -1) {
        this.selected.push(rowId);
      } else {
        this.selected.splice(index, 1);
      }

    },
    getSelectedString() {
      return `Selected ${this.selected.length} item(s)`;
    },
    ViewForm(targetID) {
      // Fetch data from the server
      axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/viewform.php?mpoform=${targetID}`)
        .then(response => {
          // Process response data
          const responseData = response.data;
          const mpoBaseData = responseData.MpoBase;
          const mpoData = responseData.MpoData;
          const suppData = responseData.SupplierData;


          this.previewForm = true;
          // Map MpoBase data to datarows
          this.datarows = mpoBaseData.map((row, index) => ({
            id: index + 1,
            sproduct: row.item_name,
            sdescription: row.description,
            squantity: row.quantity,
            sunit: row.unit,
            sunitprice: row.unit_price,
            sdiscount: row.subtotal,
            stotal: row.subtotal,
          }));

          // Assign MpoData fields to respective variables
          const time = new Date(mpoData.date_purchased).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

          this.MpoIDValue = mpoData.mpoID;
          this.company_address = mpoData.company_address;
          this.uploadPhoto = mpoData.file_logo;
          this.listService = mpoData.services;
          this.mpo_ref = mpoData.mpo_ref_no;
          this.date_purchased = time;
          this.selectedCategory = mpoData.categoryID;
          this.client_ref = mpoData.client_ref_no;
          this.wo_purchased = mpoData.w_o_ref_no;
          this.delivery_date_val = mpoData.delivery_date;
          this.delivery_add_val = mpoData.delivery_address;
          this.selectedSupplier = suppData.supplier_name;
          this.supplier_address = mpoData.supplier_address;
          this.segregation = '';
          this.cleaning = '';
          this.drying = '';
          this.weighting = '';
          this.deliver_charge = mpoData.delivery_charge ?? 0;
          this.discount = mpoData.discount ?? 0;
          this.vat = mpoData.vat ?? 0;
          this.other_cost = mpoData.other_costs ?? 0;
          this.total_amount = mpoData.total_amount ?? 0;

          // Calculate total in table
          this.total_in_table = this.datarows.reduce((total, row) => total + row.stotal, 0);

          this.notes_instructions = mpoData.notes_instructions;
          this.prepared_name = mpoData.prepared_by;
          this.approvedby_name = mpoData.approved_by;
          this.e_signatureP = mpoData.file_esignaturep;
          this.e_signatureA = mpoData.file_esignaturea;
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
    ProductReceived(targetID){

      let select = 0;
      if (this.statuss === 'received') {
        select = 2;
      }
      if (this.statuss === 'partialReceived') {
        select = 1;
      }
      if (this.statuss === 'pending') {
        select = 0;
      }
      console.log(select);
      axios.get(`https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/viewform.php?mpoform=${targetID}&selected=${select}`)
      .then(response => {
        this.product_dialog = true;
        const responseData = response.data;
        console.log(responseData)
        const mpoData = responseData.MpoData;
        const mpo_ref = `WEMA-MPO-${mpoData.date_purchased}-${mpoData.mpoID}`;
        this.mpo_ref = mpo_ref;
        const mpoBaseData = responseData.MpoBase;
        this.selectedRows = mpoBaseData.map((row, index) => {
          let sreceived = 0;
          if (row.status === 1) {
            sreceived = row.quantity_received;
          } else if (row.status === 2) {
            sreceived = row.quantity_received;
          }
          const rowData = {
            id: index + 1,
            sqlid: row.baseID,
            sproducts: row.item_name,
            sdescription: row.description,
            sqtypurchased: row.quantity,
            sunit: row.unit,
            sqtyrecieved: row.quantity_received,
            sreceived: sreceived,
            sstatus: row.status,
          };
          return rowData;
        });
      }).catch(error => {
          console.error('Error fetching data:', error);
      });
    },
    calculateStatusColor(status) {
      switch (status) {
        case 0:
          return 'red';
        case 1:
          return 'yellow';
        case 2:
          return 'green';
        default:
          return 'primary';
      }
    },
    getStatusWord(status) {
      switch (status) {
        case 0:
          return 'Pending';
        case 1:
          return 'Partial Received';
        case 2:
          return 'Received';
        default:
          return '';
      }
    },
    submitHandler() {
      if (!this.date_received) {
        this.$q.notify({
          color: 'negative',
          message: 'Please select a date before submitting.',
        });
        return;
      }
      const formData = new FormData();

      const endpoint = 'https://weavemanila.optikl.ink/backend/api/Inventory_Database/MPO_Queries/mpopage_productionlist.php/';
      formData.append('date_received', this.date_received);
      // Append each selected row to the FormData object
      this.selectedRows.forEach(row => {
        const rowData = {
          sqlid: row.sqlid,
          sproducts: row.sproducts,
          sdescription: row.sdescription,
          sqtypurchased: row.sqtypurchased,
          sunit: row.sunit,
          sqtyrecieved: row.sqtyrecieved,
          sreceived: row.sreceived,
          sstatus: row.sstatus,
        };
        formData.append('products[]', JSON.stringify(rowData));
      });

      axios.post(endpoint, formData)
        .then(response => {
          console.log(response.data);
          const Status = response.data.status;
          const Message = response.data.message;
          if (Status === "fail") {
            this.$q.notify({
              color: 'negative',
              message: `${Message} Please try again.`,
            });
            this.product_dialog = false;
          }
          if (Status === "success") {
            this.$q.notify({
              color: 'green',
              message: `Successfully Updated`,
            });
            this.fetchMPOData();
            this.product_dialog = false;
            setTimeout(() => {
              window.location.reload(); // Reload the window after 3 seconds
            }, 1500);
          }
        })
        .catch(error => {
          console.error('Error submitting data:', error);
        });
    },



    toggleProduction(){
      this.productionVisible = !this.productionVisible;
    },
    toggleInventoryMenu() {
      this.inventoryMenuVisible = !this.inventoryMenuVisible;
    },
    toggleDrawer() {
      if (!this.toggleDrawers) {
        this.drawer = true;
        this.drawerWidth = 300;
        this.drawerIcon = 'arrow_forward_ios';
        this.toggleDrawers = true;
      } else {
        this.drawer = true;
        this.drawerWidth = 80;
        this.toggleDrawers = false;
        this.drawerIcon = 'arrow_back_ios_new';
      }
    },
    checkUserStatus() {
      axios.get(`https://weavemanila.optikl.ink/backend/api/verification.php?email=${this.email}`)
      .then(response => {
        const information = response.data.information;
          this.information = {
            id: information.id,
            email: information.email,
            username: information.username,
            pfp: information.pfp,
            firstname: information.firstname,
            middlename: information.middlename,
            lastname: information.lastname,
            gender: information.gender,
            position: information.position,
            mobilenumber: information.mobilenumber,
            birthdate: information.birthdate,
            age: information.age,
            address: information.address,
            otp_code: information.otp_code,
            isOnline: information.isOnline,
            status: information.status,
            password: information.password,
            isAdmin: information.isAdmin,
            suffix: information.suffix,
            civil_status: information.civil_status
          };
          SessionStorage.set('information', JSON.stringify(this.information));

          const latestAdmin = response.data.information.isAdmin;
          const latestStatus = response.data.information.status;

          if (this.status !== latestStatus || (latestAdmin && latestStatus === 0)) {
            this.status = latestStatus;

            if (this.status === 0 && !latestAdmin) {
              this.$q.notify({
                type: 'negative',
                message: 'Your account is currently inactive. Please contact the administrator.',
              });
              this.$router.push('/');
              sessionStorage.clear();
            }
          }
      }).catch(error => {
            console.error('Error fetching data:', error);
      });
    },
    loadUserData() {
      const userData = SessionStorage.getItem('information');

      if (userData) {
        try {
          const userInformation = JSON.parse(userData);
          this.email = userInformation.email;
          this.username = userInformation.username;
          this.userProfileImage = userInformation.pfp;
          this.firstname = userInformation.firstname;
          this.middlename = userInformation.middlename;
          this.lastname = userInformation.lastname;
          this.position = userInformation.position;
          this.status = userInformation.status;
          this.isAdmin = userInformation.isAdmin;
          this.fullname = this.firstname + " " + this.lastname;
          if (this.position.toLowerCase() === 'owner'  || this.position.toLowerCase() === 'production staff' || this.position.toLowerCase() === 'warehouseman') {

            this.$router.push('/dashboard/mpo-section');
          } else {

            this.$q.notify({
              type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }

          if (this.status === 0 && !this.isAdmin) {
            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the administrator.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }

        } catch (error) {
          console.log('Error parsing user data:', error);
          // Provide user feedback or navigate to an error page
          this.$q.notify({
            type: 'negative',
            message: 'Error loading user data. Please try again.',
          });
          this.$router.push('/');
          sessionStorage.clear();
        }
      } else {
        // Handle the case when user data is not available
        this.$router.push('/');
        sessionStorage.clear();
      }
    },


    logout() {
      sessionStorage.clear();
      this.$router.push('/');
    },
  },
};
</script>

<style lang="sass">
.my-sticky-header-table
  /* height or max-height is important */
  height: 380px

  .q-table__top,

  thead tr:first-child th
    /* bg color is important for th; just specify one */
    background-color: #fff
    color: #000
    text-align: center
    font-size: 13px

  thead tr th
    position: sticky
    z-index: 1
  thead tr:first-child th
    top: 0

  /* this is when the loading indicator appears */
  &.q-table--loading thead tr:last-child th
    /* height of all previous header rows */
    top: 48px

  /* prevent scrolling behind sticky top row on focus */
  tbody
    /* height of all previous header rows */
    scroll-margin-top: 48px

</style>

