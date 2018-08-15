## dva setup中 需要获取state

今天遇到一个需求，就是在setup中，需要获取state的值。但是直接在setup是无法操作的。只是通过dispatch来操作.

```js

export default {

  namespace: 'example',

    state: {
        user_id: 1
    },

  subscriptions: {
    setup({ dispatch, history }) {  // eslint-disable-line
        dispatch({type:"test"})
    },
  },

  effects: {
    *fetch({ payload }, { call, put }) {  // eslint-disable-line
      yield put({ type: 'save' });
    },
    *test({ payload }, { call, put,select }){
		const user_id = yield select(state => state.example.user_id)
	}
  },

  reducers: {
    save(state, action) {
      console.log(action.payload)
      return { ...state, ...action.payload };
    },
  },

};

```



