<template lang="">
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Category <Button @click.prevent="addModal=true"><Icon type="md-add" /> Add Category</Button></p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <tr>
                                <th>ID</th>
                                <th>Category name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(category, i) in categories" :key="i" v-if="categories.length">
                                <td>{{ category.id }}</td>
                                <td class="_table_name">{{ category.category_name }}</td>
                                <td><img style="height: 50px; width: 50px" :src="`/uploads/${category.icon_image}`"></td>
                                <td>{{ category.created_at }}</td>
                                <td>
                                    <Button type="info" size="small" @click.prevent="showEditModal(category, i)">Edit</Button>
                                    <Button type="error" size="small" @click.prevent="showDeleteModal(category, i)" :loading="category.isDeleting">Delete</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- CATEGORY ADDING MODAL -->
            <Modal
                v-model="addModal"
                title="Add category"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="data.categoryName" placeholder="Add category name" class="_mar_b10"/>
                <Upload
                    ref="upload"
                    type="drag"
                    :headers="{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest'}"
                    :on-success="handleSuccess"
                    :on-error="handleError"
                    :format="['jpg','jpeg','png']"
                    :max-size="2048"
                    :on-format-error="handleFormatError"
                    :on-exceeded-size="handleMaxSize"
                    action="/app/upload">
                    <div style="padding: 20px 0">
                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                        <p>Click or drag files here to upload</p>
                    </div>
                </Upload>
                <div class="demo-upload-list" v-if="data.iconImage">
                    <img :src="`/uploads/${data.iconImage}`">
                    <div class="demo-upload-list-cover">
                        <Icon type="ios-eye-outline" ></Icon>
                        <Icon type="ios-trash-outline" @click.prevent="deleteImage"></Icon>
                    </div>
                </div>

                <div slot="footer">
                    <Button type="default" @click="addModal=false">Close</Button>
                    <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Category'}}</Button>
                </div>
            </Modal>
            <!-- CATEGORY EDIT MODAL -->
            <Modal
                v-model="editModal"
                title="Edit category"
                :mask-closable="false"
                :closable="false"
            >
                <Input v-model="editData.categoryName" placeholder="Edit category name" />
                <Upload
                    ref="upload"
                    type="drag"
                    :headers="{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest'}"
                    :on-success="handleEditSuccess"
                    :on-error="handleEditError"
                    :format="['jpg','jpeg','png']"
                    :max-size="2048"
                    :on-format-error="handleFormatError"
                    :on-exceeded-size="handleMaxSize"
                    action="/app/upload"
                >
                    <div style="padding: 20px 0">
                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                        <p>Click or drag files here to upload</p>
                    </div>
                </Upload>
                <div class="demo-upload-list" v-if="editData.iconImage">
                    <img :src="`/uploads/${editData.iconImage}`">
                    <div class="demo-upload-list-cover">
                        <Icon type="ios-eye-outline"></Icon>
                        <Icon type="ios-trash-outline" @click.prevent="deleteEditImage"></Icon>
                    </div>
                </div>
                <div slot="footer">
                    <Button type="default" @click="editModal=false">Close</Button>
                    <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit Category'}}</Button>
                </div>
            </Modal>
            <!-- DELETE CATEGORY MODAL -->
            <Modal v-model="deleteModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
                <div style="text-align:center">
                    <p>Are you sure you want to delete tag?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long :loading="isDeleting" :disable="isDeleting" @click.prevent="deleteTag">Delete</Button>
                </div>
            </Modal>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            data: {
                categoryName: '',
                iconImage: '',
            },
            addModal: false,
            isAdding: false,
            isDeleting: false,
            categories: [],
            editData: {
                id: null,
                categoryName: '',
                iconImage: '',
            },
            editModal: false,
            index: -1,
            deleteModal: false,
            deleteItem: {},
            deletingIndex: 1,
            token: ''
        }
    },
    methods: {
        async addCategory() {
            if (this.data.categoryName.trim() == '') {
                return this.e('Category name is required');
            }
            const res = await this.callApi('post', 'app/create-category', this.data);
            if (res.status === 201) {
                this.categories.unshift(res.data);
                this.s('Category has been added successfully!');
                this.addModal = false;
                this.data.categoryName = '';
            } else {
                if (res.status === 422) {
                    if (res.data.errors.categoryName[0]) {
                        this.e(res.data.errors.categoryName[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editCategory() {
            if (this.editData.categoryName.trim() === '') {
                return this.e('Category name is required');
            }
            const res = await this.callApi('post', 'app/edit-category', this.editData);
            if (res.status === 200) {
                this.categories[this.index] = { ...this.editData };
                this.s('Category has been edited successfully!');
                this.editModal = false;
            } else {
                if (res.status === 422 && res.data.errors.categoryName) {
                    this.e(res.data.errors.categoryName[0]);
                } else {
                    this.swr();
                }
            }
        },
        async deleteCategory() {
            this.isDeleting = true;
            const res = await this.callApi('post', 'app/delete-category', this.deleteItem);
            if (res.status === 200) {
                this.categories.splice(this.deletingIndex, 1);
                this.s('Category has been deleted successfully!');
            } else {
                this.swr()
            }
            this.isDeleting = false;
            this.deleteModal = false;
        },
        async deleteImage() {
            let image = this.data.iconImage;
            this.data.iconImage = '';
            this.$refs.upload.clearFiles();
            const res = await this.callApi('post', 'app/delete-image', { image: image });
            if (res.status !== 200) {
                this.data.iconImage = image;
                this.swr();
            }
        },
        showEditModal(category, index) {
            this.editData = {
                id: category.id,
                categoryName: category.category_name,
                iconImage: category.icon_image
            };
            this.editModal = true;
            this.index = index;
        },
        showDeleteModal(category, i) {
            this.deleteModal = true;
            this.deleteItem = category;
            this.deletingIndex = i;
        },
        handleSuccess(res, file) {
            this.data.iconImage = res
        },
        handleError(res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!'}`
            })
        },
        handleEditError(res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!'}`
            });
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },
    },
    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callApi('get', 'app/get-categories')
        if (res.status == 200) {
            this.categories = res.data
        } else {
            this.swr()
        }
    },
};
</script>
<style lang="">

</style>
