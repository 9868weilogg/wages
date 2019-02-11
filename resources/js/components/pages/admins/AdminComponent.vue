<template>
  <v-app>
    <v-content>
      <v-container fluid>
        <v-layout row wrap>
          <v-snackbar
            v-model="snackbar"
            :right="true"
            :top="true"
            :timeout="timeout"
            :color="color"
          >
            {{ text }}
            <v-progress-circular
              v-if="uploading"
              indeterminate
              color="purple"
            ></v-progress-circular>
          </v-snackbar>
          <v-flex xs12 sm6 pa-4>
            <v-card dark>
              <v-card-title primary-title>
                <div>
                  <h3 class="headline mb-0">Stock Upload</h3>
                </div>
              </v-card-title>
              <v-card-action>
                <input
                  type="file"
                  style=""
                  ref="stockList"
                  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                  v-on:change="onFilePicked()"
                >
                <v-btn 
                  v-on:click="submitStockList()"
                  block 
                  color="blue-grey" 
                  dark >
                  Submit
                </v-btn>
              </v-card-action>
            </v-card>
            
          </v-flex>
          <v-flex xs12 sm6 pa-4>
            <v-card dark>
              <v-card-title primary-title>
                <div>
                  <h3 class="headline mb-0">Sector/Industry Code Upload</h3>
                </div>
              </v-card-title>
              <v-card-action>
                <input
                  type="file"
                  style=""
                  ref="sectorIndustryCode"
                  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                  v-on:change="onFilePicked()"
                >
                <v-btn 
                  v-on:click="submitSectorIndsutryCode()"
                  block 
                  color="blue-grey" 
                  dark >
                  Submit
                </v-btn>
                </v-btn>
              </v-card-action>
            </v-card>
            
          </v-flex>
          
        </v-layout>
        
      </v-container>
    </v-content>
  </v-app>
</template>

<script>

  export default {
    components: { 
      
    },
    data () {
      return {
        stockList : '',
        sectorIndustryCode : '',
        snackbar: false,
        color: '',
        timeout: 0,
        text: 'Hello, I\'m a snackbar',
        uploading: true,
      }
    },
    
    methods: {
      onFilePicked() {
        this.stockList = this.$refs.stockList.files[0];
        this.sectorIndustryCode = this.$refs.sectorIndustryCode.files[0];
        console.log(this.stockList);
        console.log(this.sectorIndustryCode);
      },

      submitStockList() {
        let self = this;
        self.showUploadingSnackbar(self);
        
        var _formData = new FormData();
        _formData.append('file', this.stockList);
        _formData.append('filename', 'bursa_stock_list.csv');
        _formData.append('process', 'upload_bursa_stock_list');
       
        axios({
          url: '/api/stocks',
          method: 'post',
          data: _formData,
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(function(response){
          console.log(response);
          if(response.data == "Failed Update Stock List") {
            self.showFailUploadSnackbar(self);

          } else if (response.data == "Update Stock List Successfully") {
            self.showSuccessUploadSnackbar(self);
          }
        })
        .catch(function(error){
          console.log(error.response);
        })
      },

      submitSectorIndsutryCode() {
        let self = this;
        self.showUploadingSnackbar(self);
        
        var _formData = new FormData();
        _formData.append('file', this.sectorIndustryCode);
        _formData.append('filename', 'sector_industry_code.csv');
        _formData.append('process', 'upload_sector_industry_code');
       
        axios({
          url: '/api/stocks',
          method: 'post',
          data: _formData,
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(function(response){
          console.log(response);
          if(response.data == "Failed Update Sector and Industry") {
            self.showFailUploadSnackbar(self);

          } else if (response.data == "Update Sector and Industry Successfully") {
            self.showSuccessUploadSnackbar(self);
          }
        })
        .catch(function(error){
          console.log(error.response);
        })
      },

      showFailUploadSnackbar(self){
        self.snackbar = true;
        self.uploading = false;
        self.color = 'error';
        self.text = "Failed Uploading";
        setTimeout(function() {
          self.snackbar = false;
        }, 2000);
      },

      showSuccessUploadSnackbar(self){
        self.snackbar = true;
        self.uploading = false;
        self.color = 'success';
        self.text = "Successed Uploading";
        setTimeout(function() {
          self.snackbar = false;
        }, 2000);
      },

      showUploadingSnackbar(self){
        self.snackbar = true;
        self.color = 'info';
        self.text = "Uploading...";
        self.uploading = true;
      }
    }

  }
</script>
