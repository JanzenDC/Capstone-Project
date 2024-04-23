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
      <span class="font-bold">Material Purchase Order</span>
      </div>
      <div class="text-[16px]"><span class="text-[#b8b8b8]">Inventory / </span>Material Purchase Order</div>
    </div>
    <LogoutTop />
  </div>


  <div class="p-4">
    <!-- Header -->
    <div class="flex mt-3">
      <router-link to="/dashboard/mpo-section">
        <div class="flex bg-white w-[155px] border-r-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
        <q-icon name="note_add"/>
        <p>MPO Form</p>
      </div>
    </router-link>
    <router-link to="/dashboard/mpo-section">
      <div class="flex w-[155px] text-[#b8b8b8] border-t-2 border-e-2 h-[44px] py-3 px-5 gap-[8px] rounded items-center text-[14px]">
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

    <div class="w-full bg-white p-4 h-[470px] overflow-x-hidden overflow-y-auto">
      <div class=''>
          <div>
            <div>Material Purchase Order</div>
            <div class='p-2'>Category
              <div class='w-[200px]'>
                <q-select dense outlined v-model="categories" :options="options"></q-select>
              </div>
            </div>
            <div class='grid grid-cols-4 gap-1 p-2'>
              <div>
                <p>Mpo Ref. No.</p>
                <q-input disable dense outlined v-model='mpo_ref'/>
              </div>
              <div>
                <p>Date Purchased</p>
                <q-input type="date" dense outlined required v-model='date_purchased'/>
              </div>
              <div>
                <p>Client Ref. No.</p>
                <q-input type="text" dense outlined v-model='client_ref'/>
              </div>
              <div>
                <p>W.O Ref. No.</p>
                <q-input type="text" dense outlined v-model='wo_ref'/>
              </div>
              <!-- <div>
                <p>Delivery Date</p>
                <q-input type="date" dense outlined required v-model='delivery_date'/>
              </div> -->
            </div>
            <div>
              To:
              <div class='flex'>
                <div class='w-1/3 p-2'>
                  <p>
                    Supplier
                  </p>
                  <q-select :disable="isInputDisabled" dense outlined v-model="supplierValue" :options='supplierList' />
                </div>
                <div class='w-2/3 p-2'>
                  <p>
                    Supplier Address
                  </p>
                  <q-input disable dense outlined v-model='supplierAddress'/>
                </div>
              </div>
            </div>
            <div class="p-2">
              <q-table
              dense
              :rows='rows'
              :columns='columns'
              hide-bottom
              row-key="id"
              virtual-scroll
              v-model:pagination="pagination"
              :rows-per-page-options="[0]"
              >
                <template v-slot:header-cell-actions="props">
                  <q-th :props="props">
                    <q-btn icon="add_box" size="1.5em" dense class="bg-orange-500 text-white" @click="addRow"/>
                  </q-th>
                </template>
                <template v-slot:body="props">
                  <q-tr :props="props">
                    <q-td key="actions" :props="props">
                      <q-btn icon='delete' class='bg-red text-white p-2' @click="deleteRow(props.row)"/>
                    </q-td>
                    <q-td key="id" :props="props">
                      {{ props.row.id }}
                    </q-td>
                    <q-td key="product" :props="props">
                      {{ props.row.product.label }}
                      <q-popup-edit v-model="props.row.product" v-slot="scope">
                        <q-select v-model="scope.value" autofocus :options='products' dense outlined @keyup.enter="scope.set" />
                      </q-popup-edit>
                    </q-td>
                    <q-td key="description" :props="props">
                      {{ props.row.description }}
                    </q-td>
                    <q-td key="quantity" :props="props">
                      {{ props.row.quantity }}
                      <q-popup-edit v-model="props.row.quantity" v-slot="scope">
                        <q-input v-model="scope.value" autofocus type='number' dense outlined @keyup.enter="scope.set" />
                      </q-popup-edit>
                    </q-td>
                    <q-td key="unit" :props="props">
                      {{ props.row.unit }}
                    </q-td>
                    <q-td key="unit_price" :props="props">
                      {{ props.row.unit_price }}
                    </q-td>
                    <q-td key="total" :props="props">
                      {{ computeTotal(props.row) }}
                    </q-td>
                  </q-tr>
                </template>
              </q-table>
              <div class='items-end justify-end flex mt-3'>
                <div class='grid grid-cols-2 gap-1'>
                  <div>
                    Sub Total
                  </div>
                  <div>
                    ₱ {{ subtotal }}
                  </div>

                  <div>
                    Delivery Charge
                  </div>
                  <div>
                    <q-input v-model='delivery_charge' type='number' dense outlined/>
                  </div>

                  <div>
                    Other Cost
                  </div>
                  <div class="flex items-center gap-2">
                    <q-select v-model="other_cost_operator" dense outlined :options="otherCostOptions" class='w-[80px]'/>
                    <q-input v-model='other_cost' type='number' dense outlined/>
                  </div>

                  <div>
                    Discount (%)
                  </div>
                  <div class='flex items-center gap-2'>
                    <q-input v-model='discount' type='number' dense outlined class='w-[80px]'/>
                    <p>₱ {{ discount_value.toFixed(2) }}</p>
                  </div>

                  <div>
                    Tax/Vat (%)
                  </div>
                  <div class='flex items-center gap-2'>
                    <q-input v-model='tax_vat' type='number' dense outlined class='w-[80px]'/>
                    <p>₱ {{ tax_vat_value.toFixed(2) }}</p>
                  </div>

                  <div>
                    Total
                  </div>
                  <div>
                    ₱ {{ total }}
                  </div>
                </div>
              </div>
              <div class='mt-3'>
                <div>
                  Notes & Instructions
                </div>
                <q-input
                  outlined
                  class='w-[470px]'
                  type="textarea"
                  required
                  v-model='notes_instructions'
                />
              </div>
            </div>
          </div>
          <div class='flex justify-end items-end gap-2 p-2'>
            <q-btn label="Reset" class="q-mt-md" @click='ResetData'/>
            <q-btn label="Submit" class="q-mt-md bg-[#634832] text-white" @click='submitDialog'/>
          </div>
          <q-dialog
            v-model="medium"
          >
            <q-card style="width: 500px; max-width: 80vw;">
              <q-card-section>
                <div class="text-h6">Do you wish to continue?</div>
              </q-card-section>

              <q-card-section class="q-pt-none">
                It seems you want to send the form. You can double-check it by clicking "Cancel," or if you're ready to send it now, click "Submit."
              </q-card-section>

              <q-card-actions align="right" class="bg-white">
                <q-btn flat label="Cancel" v-close-popup />
                <q-btn flat label="Submit" v-close-popup class='text-teal' @click='handleSubmit'/>
              </q-card-actions>
            </q-card>
          </q-dialog>
      </div>
    </div>
  </div>

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

</q-page>
</template>

<script>
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
      OpenLogout: false,
      // Additional Data

           columns: [
        { name: 'actions', label: '', field: 'actions'},
        { name: 'id', label: 'ID', field: 'id', sortable: true },
        { name: 'product', label: 'Product', field: 'product', sortable: true },
        { name: 'description', label: 'Description', field: 'description', sortable: true },
        { name: 'quantity', label: 'Quantity', field: 'quantity', sortable: true },
        { name: 'unit', label: 'Unit', field: 'unit', sortable: true },
        { name: 'unit_price', label: 'Unit Price', field: 'unit_price', sortable: true },
        { name: 'total', label: 'Total', field: 'total', sortable: true },
      ],
      rows: [],
      categories: '',
      options: [],
      isInputDisabled: true,
      supplierValue: '',
      supplierList: [],
      supplierAddress: '',
      mpo_ref: '',
      date_purchased: '',
      client_ref: '',
      wo_ref: '',
      // delivery_date: '',
      notes_instructions: '',
      products: [],
      pagination: {
        rowsPerPage: 0
      },
      delivery_charge: 0,
      other_cost: 0,
      discount: 0,
      discount_value: 0,
      tax_vat: 12,
      tax_vat_value: 0,
      total: 0,
      otherCostOptions: [
        { label: 'Add', value: 'Add' },
        { label: 'Less', value: 'Less' }
      ],
      other_cost_operator: 'Add',
      medium: false,
      MpoIDValue: '',
    };
  },
  mounted() {
    this.loadUserData();
    this.fetchMPOdata();
    this.statusCheckTimer = setInterval(() => {
      this.checkUserStatus();
    }, 20 * 1000); // 1 second (in milliseconds)
    this.fetchCategoryData();
  },
  watch: {
    delivery_charge: 'calculateTotal',
    other_cost: 'calculateTotal',
    discount: 'calculateTotal',
    tax_vat: 'calculateTotal',
    other_cost_operator: 'calculateTotal',
    date_purchased(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.fetchMPOdata();
      }
    },
    categories(newVal) {
      // Check if a category is selected
      this.isInputDisabled = newVal ? false : true;
      this.rows = [];
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php?get=supplierGet&supplierGet=${this.categories.label}`)
      .then(response => {
        const message = response.data.status;
        if(message === 'success'){
          this.supplierList = response.data.supplierData.map(category => ({
            value: category.supplier_name,
            label: category.supplier_name
          }));
          this.rows = [];
        }
        if(message === 'fail'){
          this.supplierAddress = '';
          this.supplierValue = '';
          this.supplierList = [];
          this.isInputDisabled = true;
          this.rows = [];
        }
      })
      .catch(error => {
        // Handle any errors that occur during the HTTP request
        console.error('Error fetching data:', error.message);
      });
    },
    supplierValue() {
      // console.log(this.supplierValue.label);
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php?get=address&addressget=${this.supplierValue.label}`)
      .then(response => {
        // console.log(response.data);
        const newData = response.data.supplierData;
        this.supplierAddress = newData.address;
        this.products = response.data.informations.map(category => ({
          label: category.itemName,
          value: category.itemID
        }));
        // console.log(this.products);
        this.rows = [];
      })
      .catch(error => {
        // Handle any errors that occur during the HTTP request
        console.error('Error fetching data:', error.message);
      });
    },
    rows: {
      deep: true,
      handler(newRows, oldRows) {
        newRows.forEach(row => {
            const selectedProduct = row.product.value; // Get the selected product from row
            axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/Supplier_Database/supplier.php?get=itemData&id=${selectedProduct}`)
              .then((response) => {
                const data = response.data.itemData;

                row.description = data.description;
                // console.log(data)
                row.unit = data.unit;
                row.unit_price = data.unit_price;
              }).catch(error => {
                console.error('Error fetching data:', error);
              });
        });
      }
    },
  },



  computed: {
    subtotal() {
      return this.rows.reduce((acc, row) => acc + this.computeTotal(row), 0);
    }
  },
  beforeUnmount() {
    clearInterval(this.statusCheckTimer);
  },
  methods: {
    submitDialog(){
      this.medium = true;
    },
    ResetData(){
      this.categories = '';
      this.supplierValue = '';
      this.mpo_ref = '';
      this.date_purchased = '';
      this.client_ref = '';
      this.wo_ref = '';
      // this.delivery_date = '';
      this.notes_instructions = '';
      this.rows = [];
    },
    handleSubmit() {
      const missingFields = [];

      if (!this.date_purchased) {
        missingFields.push('Date Purchased');
      }
      // if (!this.delivery_date) {
      //   missingFields.push('Delivery Date');
      // }
      if (!this.notes_instructions) {
        missingFields.push('Notes & Instructions');
      }
      if (missingFields.length > 0) {
        this.$q.notify({
          color: 'negative',
          message: `Please fill in all required fields: ${missingFields.join(', ')}.`,
        });
        return; // Stop further execution
      }

      const formData = new FormData();
      // Append form data to the FormData object
      formData.append('categories', this.categories.label);
      formData.append('supplierValue', this.supplierValue.label);
      formData.append('supplierAddress', this.supplierAddress);
      formData.append('mpo_ref', this.mpo_ref);
      formData.append('date_purchased', this.date_purchased);
      formData.append('client_ref', this.client_ref);
      formData.append('wo_ref', this.wo_ref);
      // formData.append('delivery_date', this.delivery_date);
      formData.append('notes_instructions', this.notes_instructions);
      formData.append('total', this.total);
      const subtotal = this.rows.reduce((acc, row) => acc + this.computeTotal(row), 0);
      formData.append('subtotal', subtotal);
      formData.append('delivery_charge', this.delivery_charge);
      formData.append('other_cost', this.other_cost);
      formData.append('discount_value', this.discount);
      formData.append('tax_vat', this.tax_vat);
      formData.append('tax_vat_value', this.tax_vat_value);

      this.rows.forEach(row => {
        const total = row.quantity * row.unit_price;
        const productData = {
            product: row.product.label,
            description: row.description,
            quantity: row.quantity,
            unit: row.unit,
            unit_price: row.unit_price,
            total: total,
        };
        console.log('Product Data:', productData);
        formData.append('products[]', JSON.stringify(productData));
    });

      axios.post('http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php/', formData)
      .then(response => {
        console.log(response.data);
        const Status = response.data.status;
        const Message = response.data.message;
        if (Status === "success") {
          this.$q.notify({
            message: `MPO ${this.MpoIDValue} save successfully!`,
            color: 'green',
            type: 'positive',
          });
          this.ResetData();
        }
        if (Status === "fail") {
          this.$q.notify({
            color: 'negative',
            message: `${Message} Please try again.`,
          });
          this.ResetData();
        }
      }).catch(error => {
        console.error('Error fetching data:', error.message);
      });
    },
    deleteRow(rowIndex) {
      this.rows.splice(rowIndex, 1);
    },
    fetchMPOdata(){
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=mpo`)
      .then(response => {
        let nextMPOID = response.data.nextMPOID;
        if (nextMPOID === undefined) {
            nextMPOID = 1;
        }
        console.log(response.data);
        const startingNo = response.data.nextMPOStartingNo[0];
        // const currentDate = new Date();
        // const year = currentDate.getFullYear();
        // const month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
        // const day = ('0' + currentDate.getDate()).slice(-2);
        const mpo_ref = `WEMA${startingNo.maxStartingNo}-MPO-${this.date_purchased}-${nextMPOID}`;
        this.MpoIDValue = nextMPOID;
        this.mpo_ref = mpo_ref;
      })
      .catch(error => {
        // Handle any errors that occur during the HTTP request
        console.error('Error fetching data:', error.message);
      });
    },
    calculateTotal() {
      let total = this.subtotal + parseFloat(this.delivery_charge);
      const operator = this.other_cost_operator;
      if (operator === 'Add') {
        total += parseFloat(this.other_cost);
      } else if (operator === 'Less') {
        total -= parseFloat(this.other_cost);
      }
      const discountDecimal = parseFloat(this.discount) / 100;
      total -= this.subtotal * discountDecimal;
      this.discount_value = this.subtotal * discountDecimal;
      const tax_vat = parseFloat(this.tax_vat) / 100;
      const vatAmount = total * tax_vat;
      this.tax_vat_value = this.subtotal * tax_vat;

      this.total = total + vatAmount;
    },
    computeTotal(row) {
      // Calculate total by multiplying quantity and unit_price
      return row.quantity * row.unit_price;
    },
    addRow() {
      if (this.supplierValue === '') {
        return;
      }
      const newRow = {
        id: this.rows.length + 1,
        product: '',
        description: '',
        quantity: '',
        unit: '',
        unit_price: '',
        total: '',
      };
      this.rows.push(newRow);
    },
    fetchCategoryData(){
      axios.get(`http://localhost/Capstone-Project/backend/api/Inventory_Database/MPO_Queries/mpo_data.php?get=category`)
      .then(response => {
        console.log(response.data);
          this.options = response.data.categoryData.map(category => ({
            value: category.title,
            label: category.title
          }));
      })
      .catch(error => {
        // Handle any errors that occur during the HTTP request
        console.error('Error fetching data:', error.message);
      });
    },

// OLD DATA
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
          if (this.position.toLowerCase() === 'owner') {

            this.$router.push('/dashboard/mpoform-section');
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
    logout() {
      sessionStorage.clear();
      this.$router.push('/');
    },
  },
};
</script>
