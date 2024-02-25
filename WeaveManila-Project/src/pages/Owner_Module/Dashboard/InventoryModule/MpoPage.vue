<template>
<q-drawer
show-if-above
v-model="drawer"
side="left"
bordered
:width="drawerWidth">
  <ul class=" p-2 flex flex-col h-full static" v-if="drawerWidth !== 80">
    <div class="flex">
      <div class="w-1/4 items-center flex justify-center" >
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[50px] md:w-[60px]"
        />
      </div>
      <div class=" items-center flex justify-center" v-if="drawerWidth <= 80">
        <q-img
          src="../../../../assets/favicon-128x128.png"
          alt="Description of the image"
          class="w-[150px] md:w-[60px]"
        />
      </div>
      <div class="text-[#281c0f] text-[18px] w-3/4 flex justify-center items-center gap-1" v-if="drawerWidth !== 80">
      <div>
        <span class="font-bold ">WEAVEMANILA INC.</span><br>
      </div>
      <div>
        <q-icon name="keyboard_double_arrow_right" class="text-[30px] cursor-pointer" @click="toggleDrawer" />
      </div>
    </div>

    </div>



    <li class="font-bold mt-5">Menu</li>
      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center">
          <router-link to="/dashboard/main-dashboard">
          <q-icon name="dashboard" class="mr-2" /> <span >Dashboard</span>
          </router-link>
        </div>
      </li>

      <li class="py-[10px] px-[20px]" @click="toggleInventoryMenu">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/> <span >Inventory</span></div>
          <div><q-icon name="expand_more"  /> </div>
        </div>
        <ul v-if="inventoryMenuVisible">
          <router-link to="/dashboard/inventory-section">
            <li class="py-[2px] px-[40px] mt-3">Materials</li>
          </router-link>
          <router-link to="/dashboard/mpoform-section">
            <li class="px-[40px] mt-3"> Material Purchase Order</li>
          </router-link>
        </ul>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2">
          <i class="bi bi-box-seam"></i> <span >Product Monitoring</span>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <q-icon name="assignment_add" class="mr-2"/><span>Report</span>
        </div>
      </li>
      <!-- Settings Section -->
      <li class="font-bold" >Admin</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/auditlogs-section">
            <i class="bi bi-activity mr-2"></i> <span >Audit Logs</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/usermanagement-section">
            <q-icon name="group" class="mr-2"/> <span >User Management</span>
          </router-link>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center">
          <router-link to="/dashboard/account-settings">
            <q-icon name="manage_accounts" class="mr-2"/> <span >Account Settings</span>
          </router-link>
        </div>
      </li>

      <li class="mt-auto py-[10px]">
        <q-separator />
        <div class="flex justify-between text-center" >
          <div class="flex items-center" >
            <q-img
              :src="getUserProfileImagePath()"
              alt="Description of the image"
              class="w-12 md:w-12 rounded-full"
            />
            <div class="ml-2 overflow-hidden">
              <div class="whitespace-nowrap overflow-hidden text-overflow-ellipsis font-bold">
                {{ getLimitedFullname(fullname, 25) }}
              </div>
              <div class="text-center">
                {{ position }}
              </div>
            </div>
          </div>
          <div class="flex items-center ">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
          </div>
        </div>
      </li>
  </ul>

  <ul class="p-2 flex flex-col h-full static" v-if="drawerWidth <= 80">

    <div class="flex justify-center items-center text-[40px]">
      <div class=" items-center flex justify-center cursor-pointer" v-if="drawerWidth <= 80">
        <q-icon name="keyboard_double_arrow_right" @click="toggleDrawer"/>
      </div>
    </div>

      <li class="mt-5 text-center">Menu</li>
      <li class="py-[10px] px-[20px]" >
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="dashboard" />
        </div>
      </li>
      <!-- Process Section -->

      <li class="py-[10px] px-[20px]" @click="toggleDrawer">
        <div class="flex items-center gap-2 justify-between">
          <div><q-icon name="inventory"/></div>
        </div>
      </li>

      <li class="py-[10px] px-[20px] ">
        <div class="flex items-center gap-2" @click="toggleDrawer">
          <i class="bi bi-box-seam"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
          <q-icon name="description" />
        </div>
      </li>
      <li class="text-center">Admin</li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <i class="bi bi-activity"></i>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="group" class="mr-2"/>
        </div>
      </li>
      <li class="py-[10px] px-[20px]">
        <div class="flex items-center" @click="toggleDrawer">
            <q-icon name="manage_accounts"/>
        </div>
      </li>
      <li class="mt-auto py-[10px]">
          <div class="flex justify-center ">
            <router-link @click="logout" to="/">
              <q-icon name="logout" class="h-[18px] w-[20px] font-bold"/>
            </router-link>
          </div>
      </li>
  </ul>
</q-drawer>
<q-page class="bg-[#f5f5f5] ">
  <div class="text-[30px] bg-white p-2 ">
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

  <div class="p-4">
    <div class="flex mt-3">
      <router-link to="/dashboard/mpoform-section">
        <div class="flex w-[155px] text-[#b8b8b8] border-t-2 border-l-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="note_add"/>
          <p>MPO Form</p>
        </div>
      </router-link>
      <router-link to="/dashboard/mpo-section">
        <div class="flex bg-white w-[155px] border-r-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
          <q-icon name="list"/>
          <p>Purchase list</p>
        </div>
      </router-link>
      <router-link to="/dashboard/supplier-section">
        <div class="flex w-[155px] text-[#b8b8b8] border-t-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
            <q-icon name="group"/>
            <p>Supplier List</p>
          </div>
      </router-link>
    </div>

    <div class="w-full bg-white p-4">
      <div class="flex md:items-end md:justify-between">
          <div class="flex items-center gap-2">
            <q-input outlined dense placeholder="Search" class="md:w-[400px]">
              <template v-slot:prepend>
                <q-icon name="search" />
              </template>
            </q-input>
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
            <q-btn square icon="cached" @click="refreshData"/>
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
            selection="multiple"
            v-model:selected="selected"
            :selected-rows-label="getSelectedString"
          >
          <template v-slot:body-cell-selection="props">
            <q-td :props="props">
              <q-checkbox
                v-model="props.selected"
                :val="props.row.mpo_id"
                @input="handleCheckboxChange(props.row.mpo_id)"
              />
            </q-td>
          </template>

          <template v-slot:body-cell-product="props">
            <q-td :props="props">
              <div v-if="props.row.product && props.row.product.length > 0">
                <!-- Iterate over each product -->
                <div v-for="(product, index) in props.row.product" :key="index">
                  <div v-if="product !== null">
                    <!-- Expand icon -->
                    <q-icon  name="expand_more" @click="toggleExpand(props.row.mpo_id, product)" />
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
                  <div @click="ProductReceived(props.row.mpo_id)" class="bg-[#ddffcd] rounded py-1 px-2 text-green-600 rounded font-bold cursor-pointer">
                    Received
                  </div>
                  <div class="bg-[#475467] rounded text-white cursor-pointer w-[32px] h-[32px] text-[20px]">
                    <q-icon name="history" />
                  </div>
                  <div class="bg-[#26218e] rounded text-white cursor-pointer w-[32px] h-[32px] text-[20px]">
                    <q-icon name="assignment" @click="ViewForm(props.row.mpo_id)"/>
                  </div>
                  <div class="bg-[#b3261e] rounded text-white cursor-pointer text-[20px] w-[32px] h-[32px]">
                    <q-icon name="delete"/>
                  </div>
                  <div class="w-[32px] h-[32px] cursor-pointer text-[20px]">
                    <q-icon name="arrow_forward_ios"/>
                  </div>
                </div>
              </q-td>
        </template>



        </q-table>
      </div>
    </div>
  </div>

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
                          :src="getDefaultImage('prepared')"
                          alt="Description of the image"
                          class="w-[50px] h-[50px]"
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
              <div class="w-full p-2 flex justify-center items-center">
                  <table class="w-full">
                      <thead class="bg-[#f6f8fa] text-left border">
                          <tr>
                              <th class="px-4 py-2 w-[500px]">To</th>
                              <th class="px-4 py-2">Process</th>

                          </tr>
                      </thead>
                      <tbody>
                          <tr class="border-b border">
                              <td class="px-4 py-2 border-l border">{{ selectedSupplier }}</td>
                              <td class="px-4 py-2 border-l border-r border grid grid-cols-2">
                                <p>
                                  Segregation
                                </p>
                                <label>{{ segregation }}</label>
                              </td>
                          </tr>
                          <tr class="">
                              <td class="border-l "></td>
                              <td class="px-4 py-2 border-l border-r border grid grid-cols-2">
                                <p>
                                  Cleaning
                                </p>
                                <label>{{ cleaning }}</label>
                              </td>
                          </tr>
                          <tr>
                              <td class="px-4 py-2 border-l ">{{ supplier_address }}</td>
                              <td class="px-4 py-2 border-l border-r border-t border grid grid-cols-2">
                                <p>
                                  Drying
                                </p>
                                <label>{{ drying }}</label>
                              </td>
                          </tr>
                          <tr>
                              <td class="px-4 py-2 border-b border-l"></td>
                              <td class="px-4 py-2 border grid grid-cols-2">
                                <p>
                                  Weighting
                                </p>
                                <label>{{ weighting }}</label>
                              </td>
                          </tr>
                      </tbody>
                  </table>
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
                      <th class="px-4 py-2">Discount</th>
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
                      <td class="px-4 py-2">10</td>
                      <td class="px-4 py-2">₱{{ row.stotal }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="w-full p-2 flex items-center">
                <div class="w-1/2">
                  <div class="border bg-[#f6f8fa] p-2 ">
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
                    <div>₱ {{ discount }}</div>
                    <div class="font-bold">TAX/VAT</div>
                    <div>₱ {{ vat }}</div>
                    <div class="font-bold">Total Amount</div>
                    <div>₱ {{ total_amount }}</div>
                  </div>
                </div>
              </div>
              <div class="w-full p-14 flex text-center justify-center items-center">
                <div class="w-1/2 text-center">
                  <p class="font-bold">Approved by</p>
                  <q-img
                    :src="getDefaultImage('approved')"
                    alt="Description of the image"
                    class="w-[50px] h-[50px]"
                  />
                  <p class="font-bold">{{ approvedby_name }}</p>
                </div>
                <div class="w-1/2 text-center">
                  <p class="font-bold">Prepared by</p>
                  <q-img
                    :src="getDefaultImage('prepared')"
                    alt="Description of the image"
                    class="w-[50px] h-[50px]"
                  />
                  <p class="font-bold">{{ prepared_name }}</p>

                </div>
              </div>
            </div>
          </div>

        </q-card-section>
      </q-card>
</q-dialog>

<!-- PRODUCT RECIEVED -->
<q-dialog v-model="product_dialog">
  <q-card class="w-[472px]">
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
      <div>
        <label>MPO Ref. No</label>
        <q-input dense outlined disable v-model="mpo_ref"/>
      </div>
      <div class="mt-3">
        <label>Date Received</label>
        <q-input dense outlined type="date"/>
      </div>
      <div class="grid grid-cols-2 gap-2 mt-3">
        <div>
          <label>Quantity Purchased</label>
          <q-input dense outlined disable type="number"/>
        </div>
        <div>
          <label>Quantity Received</label>
          <q-input dense outlined type="number"/>
        </div>
      </div>
    </q-card-section>
    <q-card-actions align="right">
      <q-btn v-close-popup flat class="bg-[#634832] text-white" label="Submit" />
    </q-card-actions>
  </q-card>
  </q-dialog>
</q-page>
</template>

<script>
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import { SessionStorage } from 'quasar';
import axios from 'axios';

export default {
  data() {
    return {
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

      // Additional Data
      firstStep: false,
      secondStep: false,
      columns: [
        { name: 'mpo_number', align: 'left', label: 'MPO No.', field: 'mpo_number', sortable: true, headerStyle: 'width: 44px;' },
        { name: 'supplier', align: 'left', label: 'Supplier', field: 'supplier', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'product', align: 'left', label: 'Product', field: 'product', sortable: true, headerStyle: 'width: 150px;' },
        { name: 'date_purchase', align: 'left', label: 'Date Purchase', field: 'date_purchase', sortable: true, headerStyle: 'width: 120px;' },
        { name: 'qty', align: 'left', label: 'Qty', field: 'qty', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'qty_received', align: 'left', label: 'Qty Received', field: 'qty_received', sortable: true, headerStyle: 'width: 120px;' },
        { name: 'amount', align: 'left', label: 'Amount', field: 'amount', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'actions', align: 'center', label: 'Actions', field: 'actions', sortable: true },
      ],

      rows: [],
      selected: [],
      previewForm: false,
      product_dialog: false,
      // Second Process Data
      datacolumns: [
        { name: 'id', align: 'left', label: '#', field: 'id', sortable: true },
        { name: 'sproduct', align: 'left', label: 'Product', field: 'sproduct', sortable: true },
        { name: 'sdescription', align: 'left', label: 'Description', field: 'sdescription', sortable: true },
        { name: 'squantity', align: 'left', label: 'Quantity', field: 'squantity', sortable: true },
        { name: 'sunit', align: 'left', label: 'Unit', field: 'sunit', sortable: true },
        { name: 'sunitprice', align: 'left', label: 'Unit Price', field: 'sunitprice', sortable: true },
        { name: 'sdiscount', align: 'left', label: 'Discount', field: 'sdiscount', sortable: true },
        { name: 'stotal', align: 'left', label: 'Sub Total', field: 'stotal', sortable: true },
        { name: 'sactions', align: 'left', label: 'Actions', field: 'sactions', sortable: true },
      ],
      datarows: [],
      expandedProducts: [],
      company_address: '',
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
    };
  },
  mounted() {
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

        const pageWidth = 210; // A4 width in mm
        const pageHeight = 297; // A4 height in mm

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
        console.log(this.selectedSupplier);
        // Send the FormData via email using Axios
        axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/viewform.php/', formData)
          .then(response => {
            const Status = response.data.status;
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

        const pageWidth = 210; // A4 width in mm
        const pageHeight = 297; // A4 height in mm

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
    getDefaultImage(type) {
      switch (type) {
        case 'prepared':
          return this.e_signatureP ? `/Important_Images/${this.e_signatureP}` : this.getDefaultImageUrl('prepared');
        case 'approved':
          return this.e_signatureA ? `/Important_Images/${this.e_signatureA}` : this.getDefaultImageUrl('approved');
        case 'logo':
          return this.uploadPhoto ? `/Important_Images/${this.uploadPhoto}` : this.getDefaultImageUrl('logo');
        default:
          return null; // or any default image source you want to set
      }
    },
    getDefaultImageUrl(type) {
      switch (type) {
        case 'prepared':
          return '/default.png';
        case 'approved':
          return '/default.png';
        case 'logo':
          return '/default_logo.png';
        default:
          return null; // or any default image URL you want to set
      }
    },
    refreshData(){
      this.fetchMPOData();
    },
    fetchMPOData() {
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=alldata`)
        .then(response => {
          console.log(response.data);

          const groupedData = response.data.categoryData.reduce((acc, row) => {
              if (!acc[row.mpoID]) {
                  acc[row.mpoID] = {
                      mpo_id: row.mpoID,
                      mpo_number: row.mpo_ref_no,
                      supplier: row.supplier_name,
                      date_purchase: row.date_purchased,
                      product: [],
                      qty: [],
                      total: [],
                      amount: [],
                      status: [],
                      qty_received: [] // Initialize qty_received array here
                  };
              }
              acc[row.mpoID].amount.push(row.subtotal);
              acc[row.mpoID].product.push(row.item_name);
              acc[row.mpoID].qty.push(row.quantity);
              acc[row.mpoID].qty_received.push(row.quantity_balance);
              let mpo_status = row.status;
              let status = '';
              if (mpo_status === 2) {
                  status = '● Received';
              } else if (mpo_status == 1) {
                  status = '● Partial Received';
              } else {
                  status = '● Pending';
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
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/viewform.php?mpoform=${targetID}`)
        .then(response => {
          // Process response data
          const responseData = response.data;
          const mpoBaseData = responseData.MpoBase;
          const mpoData = responseData.MpoData;
          const suppData = responseData.SupplierData;

          console.log(suppData);
          this.previewForm = true;
          // Map MpoBase data to datarows
          this.datarows = mpoBaseData.map((row, index) => ({
            id: index + 1,
            sproduct: row.item_name,
            sdescription: row.description,
            squantity: row.quantity_balance,
            sunit: row.unit,
            sunitprice: row.unit_price,
            sdiscount: row.subtotal,
            stotal: row.subtotal,
          }));

          // Assign MpoData fields to respective variables
          this.MpoIDValue = mpoData.mpoID;
          this.company_address = mpoData.company_address;
          this.uploadPhoto = mpoData.file_logo;
          this.mpo_ref = mpoData.mpo_ref_no;
          this.date_purchased = mpoData.date_purchased;
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
          this.other_cost = mpoData.other_cost ?? 0;
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
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/viewform.php?mpoform=${targetID}`)
      .then(response => {
        this.product_dialog = true;
        const responseData = response.data;
        const mpoBaseData = responseData.MpoBase;
        const mpoData = responseData.MpoData;
        const suppData = responseData.SupplierData;
        const mpo_ref = `WEMA-MPO-${mpoData.date_purchased}-${mpoData.mpoID}`;
        this.mpo_ref = mpo_ref;
      }).catch(error => {
          console.error('Error fetching data:', error);
        });
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
        axios.get(`http://localhost/Capstone-Project/backend/api/verification.php?email=${this.email}`)
        .then(response => {
        const latestStatus = response.data.information.status;
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
          };
          SessionStorage.set('information', JSON.stringify(this.information));
        // Update the local status and take appropriate action if it has changed
        if (this.status !== latestStatus) {
          this.status = latestStatus;

          if (this.status === 0) {
            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
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

          this.fullname = this.firstname + " " + this.lastname;
          if (this.position.toLowerCase() === 'owner') {

            this.$router.push('/dashboard/mpo-section');
          } else {

            this.$q.notify({
              type: 'negative',
              message: 'You do not have permission to access the system.',
            });
            this.$router.push('/');
            sessionStorage.clear();
          }

          if (this.status == 0) {

            this.$q.notify({
              type: 'negative',
              message: 'Your account is currently inactive. Please contact the account owner for activation.',
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
    getLimitedFullname(fullname, maxLength) {
      if (fullname.length > maxLength) {
        return fullname.substring(0, maxLength) + '...';
      }
      return fullname;
    },
    getUserProfileImagePath() {
      // Ensure userProfileImage is not null before creating the path
      if (this.userProfileImage) {
        return `/pfp/${this.userProfileImage}`;
      } else {
        // Return a default path or handle it as per your requirement
        return '/default_profile.png';
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
  height: 370px

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

