@extends('core::layouts.master')
@section('title')
    {{ trans_choice('core::general.create',1) }} {{ trans_choice('loan::general.application',1) }}
@endsection
@section('content')
    <div class="nk-block-head-content mb-4">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">{{ trans_choice('core::general.create',1) }} {{ trans_choice('loan::general.application',1) }}</h3>
                    <div class="nk-block-des text-soft">

                    </div>
                </div><!-- .nk-block-head-content -->
                <div class="nk-block-head-content">
                    <a href="#" onclick="window.history.back()"
                       class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em><span>{{ trans_choice('core::general.back',1) }}</span>
                    </a>

                </div><!-- .nk-block-head-content -->
            </div><!-- .nk-block-between -->
        </div>
    </div>
    <div class="nk-block nk-block-lg" id="app">
        <form method="post" action="{{ url('portal/loan/application/store') }}">
            {{csrf_field()}}
            <div class="card card-bordered card-preview">
                <div class="card-inner">

                    <div class="form-group">
                        <label for="loan_product_id"
                               class="control-label">{{trans_choice('loan::general.loan',1)}} {{trans_choice('loan::general.product',1)}}</label>
                        <v-select label="name" :options="loan_products"
                                  :reduce="loan_product => loan_product.id"
                                  v-on:input="change_loan_product"
                                  v-model="loan_product_id">
                            <template #search="{attributes, events}">
                                <input
                                        autocomplete="off"
                                        class="vs__search @error('loan_product_id') is-invalid @enderror"
                                        v-bind="attributes"
                                        v-bind:required="!loan_product_id"
                                        v-on="events"
                                />
                            </template>
                        </v-select>
                        <input type="hidden" name="loan_product_id"
                               v-model="loan_product_id">
                        @error('loan_product_id')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="amount"
                               class="control-label">{{trans_choice('loan::general.amount',1)}}</label>
                        <input type="number" name="amount" id="amount" v-bind:max="max_amount" v-bind:min="min_amount"
                               class="form-control @error('amount') is-invalid @enderror numeric"
                               v-model="amount" required>
                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group">

                    </div>
                    <div class="form-group">
                        <label for="notes"
                               class="control-label">{{trans_choice('core::general.note',2)}}</label>
                        <textarea type="text" name="notes" id="notes" v-model="notes" class="form-control @error('notes') is-invalid @enderror "
                                  rows="3"></textarea>
                        @error('notes')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer border-top ">
                    <button type="submit"
                            class="btn btn-primary  float-right">{{trans_choice('core::general.save',1)}}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {

                amount: "{{old('amount')}}",
                loan_product_id: parseInt("{{old('loan_product_id')}}"),
                notes: `{{old('notes')}}`,
                max_amount: "",
                min_amount: "",
                loan_products: loan_products,

            },
            created: function () {
                //this.loan_charges=charges;

            },
            methods: {
                change_loan_product(event) {
                    if (this.loan_product_id != "") {
                        var loan_product = loan_products[this.loan_product_id];
                        this.loan_products.forEach(item => {
                            if (item.id == this.loan_product_id) {
                                this.loan_product = item;
                                this.amount = loan_product.default_principal;
                                this.max_amount = loan_product.maximum_principal;
                                this.min_amount = loan_product.minimum_principal;
                            }
                        })

                    } else {
                        alert('Please select a product')
                    }
                },
                onSubmit() {

                }
            }
        });
    </script>
@endsection