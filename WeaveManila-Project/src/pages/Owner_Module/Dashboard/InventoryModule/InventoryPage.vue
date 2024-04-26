<template>
<SideBar />
<q-page class="bg-[#f5f5f5] ">
  <div class='flex justify-between items-center text-[30px] bg-white p-2'>
    <div class="">
      <div class="items-center flex ">
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
      <span class="font-bold">Inventory</span>
      </div>
      <div class="text-[16px]">Efficiently manage and track your stock for streamlined supply chain operations and optimized inventory.</div>
    </div>
    <LogoutTop />
  </div>

  <div class="p-4">
    <div class="p-4 overflow-y-auto overflow-x-hidden h-[500px] bg-white">
      <div class='justify-between flex'>
        <div>
          <q-input v-model='search' dense outlined label='Search...'>
            <template v-slot:prepend>
              <q-icon name="search" />
            </template>
          </q-input>
        </div>
        <div class='flex gap-3'>
          <q-btn icon="download"/>
          <q-btn icon="print"/>
          <q-btn-dropdown label="Category">
            <q-list>
              <q-item >
                <q-item-label class='cursor-pointer' @click="onItemClick(null)" >All Categories</q-item-label>
              </q-item>
              <q-item v-for="(category, index) in categories" :key="index" >
                <q-item-label class='cursor-pointer' @click="onItemClick(category.categoryID)">{{ category.title }}</q-item-label>
              </q-item>
            </q-list>
          </q-btn-dropdown>
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
              </div>
            </div>
          </q-td>
        </template>

        <template v-slot:body-cell-qty="props">
          <q-td :props="props">
            <div v-for="qty in props.row.qty" :key="qty">{{ qty }}</div>
          </q-td>
        </template>

        <template v-slot:body-cell-qty_balance="props">
          <q-td :props="props">
            <div v-for="qty in props.row.qty_balance" :key="qty">{{ qty }}</div>
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
                <div class="flex items-center justify-center w-[100px] gap-1">
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
</q-page>


</template>

<script>
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import { SessionStorage } from 'quasar';
import axios from 'axios';
import SideBar from '../Essentials/SideBar.vue';
import LogoutTop from '../Essentials/LogoutTop.vue';
export default {
  components: {
    SideBar,
    LogoutTop
  },
  data() {
    return {
      previewForm: false,
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
      addCategory: false,
      drawer: false,
      showMenuIcon: false,
      statusCheckTimer: null,
      toggleDrawers: true,
      drawerWidth: 300,
      drawerIcon: 'arrow_back_ios',
      inventoryMenuVisible: false,
      productionVisible: false,
      OpenLogout: false,
      // Add DATA
      search: '',
      categories: [],
      columns: [
        { name: 'mpo_number', align: 'left', label: 'MPO No.', field: 'mpo_number', sortable: true, headerStyle: 'width: 44px;' },
        { name: 'supplier', align: 'left', label: 'Supplier', field: 'supplier', sortable: true, headerStyle: 'width: 100px;' },
        { name: 'product', align: 'left', label: 'Product', field: 'product', sortable: true, headerStyle: 'width: 150px;' },
        { name: 'qty', align: 'left', label: 'Qty Purchased', field: 'qty', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'qty_balance', align: 'left', label: 'Qty Balance', field: 'qty_balance', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'status', align: 'left', label: 'Status', field: 'status', sortable: true, headerStyle: 'width: 80px;' },
        { name: 'actions', align: 'center', label: 'Actions', field: 'actions',headerStyle: 'width: 50px', },
      ],

      rows: [],
      MpoIDValue: '',
      company_address: '',
      uploadPhoto: '',
      listService: '',
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
    };
  },
  mounted() {
    this.fetchMPOData();
    this.fetchCategory();
    this.loadUserData();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
    this.clearInventoryData();
    this.fetchImageLogo();
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
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
        // Send the FormData via email using Axios
        axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/viewform.php/', formData)
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
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=companylogo`)
      .then(response => {
          console.log('selectAdmin', response.data.isAdmin);
          this.companyimage = response.data.isAdmin.company_logo;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
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
          this.MpoIDValue = mpoData.mpoID;
          this.company_address = mpoData.company_address;
          this.uploadPhoto = mpoData.file_logo;
          this.listService = mpoData.services;
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
    onItemClick(category) {
      if (category == null) {
        this.fetchMPOData();
      } else {
        axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php?type=4&id=${category}`)
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
                        qty_balance: [],
                    };
                }
                acc[row.mpoID].amount.push(row.subtotal);
                acc[row.mpoID].product.push(row.item_name);
                acc[row.mpoID].qty.push(row.quantity);


                acc[row.mpoID].qty_balance.push(row.quantity_received);

                // Calculate status based on received quantity
                let status = '';
                if (row.quantity_received === row.quantity || row.quantity_received >= 300)  {
                    status = 'In Stock';
                }
                if (row.quantity_received === 0) {
                    status = 'Out of Stock';
                } if (row.quantity_received  <= 300) {
                  status = 'Low Stock';
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
    fetchMPOData() {
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php?type=3`)
      .then(response => {
        console.log(response.data)
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
                    qty_balance: [],
                };
            }
            acc[row.mpoID].amount.push(row.subtotal);
            acc[row.mpoID].product.push(row.item_name);
            acc[row.mpoID].qty.push(row.quantity);


            acc[row.mpoID].qty_balance.push(row.quantity_received);

            // Calculate status based on received quantity
            if (row.quantity_received === row.quantity || row.quantity_received > 300) {
                status = 'In Stock';
            } else if (row.quantity_received === 0) {
                status = 'Out of Stock';
            } else if (row.quantity_received < 300 && row.quantity_received > row.quantity / 2) {
                status = 'Low Stock';
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
    fetchCategory() {
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=category`)
        .then(response => {
          // Assuming response.data is an array of categories
          this.categories = response.data.categoryData;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    clearInventoryData() {
      sessionStorage.removeItem('inventoryData');
    },
    onSubmit(){
      const formData = {
        title: this.title,
        procedure: this.selectedProcedure,
        description: this.description,

      }
      axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/inventory.php/', formData)
      .then(response => {

        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
              message: 'Category Added!!',
              caption: `${Message}`,
              color: 'green',
          });
          this.title = '';
          this.description = '';
          this.procedureOptions = [];
          this.addCategory = false;
          this.fetchData();
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

    calculateStatus(status) {
      switch (status) {
        case 'Out of Stock':
          return 'red';
        case 'Low Stock':
          return 'yellow';
        case 'On Stock':
          return 'green';
        default:
          return 'gray'
      }
    },
    toNextPage(targetID) {
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpopage_segregation.php?select=${targetID}`)
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
    isValidDate(dateString) {
      // Attempt to create a Date object from the dateString
      const date = new Date(dateString);
      // Check if the date object is valid
      // If it's an invalid date or "No Data", return false
      return !isNaN(date.getTime()) && dateString !== 'No Data';
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

            this.$router.push('/dashboard/inventory-section');
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
  },
};
</script>
