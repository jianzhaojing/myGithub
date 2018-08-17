页面
<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="80">ID</th>
				<th width="100">用户名</th>
				<th width="40">性别</th>
				<th width="90">手机</th>
				<th width="150">邮箱</th>
				<th width="130">加入时间</th>
				<th width="70">状态</th>
				<th width="100" >操作</th>
			</tr>
		</thead>
		<tbody>

        </tbody>
</table>
js部分
 <script>
            $(function () {
               var datatable = $('.table-sort').dataTable({
                    "lengthMenu": [ 2, 4, 8 ],
                    "paging": true,
                    "info":true,
                    "searching": false,
                    "ordering": true,
                    "order": [[ 1, "desc" ]],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                            "url": "{{route('admin.manager.index')}}",
                            "type": "POST",
                            //'data': { '_token' : "{{ csrf_token() }}" }
                            "data":function(query)
                            {
                                query._token = "{{ csrf_token() }}";
                                query.datemin = $('#datemin').val();
                                query.datemax = $('#datemax').val();
                                query.username = $('#username').val();
                            }
                            },
                    "columns": [
                            {'data':'a',"defaultContent":  `<input type="checkbox" name="" value="">` },
                            {'data':'id'},
                            {'data':'username',"defaultContent":''},
                            {'data':'sex',"defaultContent":''},
                            {'data':'phone',"defaultContent":''},
                            {'data':'email',"defaultContent":''},
                            {'data':'created_at',"defaultContent":''},
                            {'data':'static',"defaultContent":''},
                            {'data':'b',"defaultContent":'',className:'do'}
                             ],
                    "createdRow":function(row,data,dataIndex){
                        let btnGroupHtml = `<a href="#" class="btn btn-primary size-MINI">修改</a>
                                    <a href="#" class="btn btn-danger size-MINI">删除</a>`;
                        $(row).find('td:eq(8)').html(btnGroupHtml);
                    }
            });
                //添加按钮事件
                $('#searching').click(function(){
                    datatable.api().ajax.reload();
                });
            });
        </script>
控制器部分
public function index(Request $request)
    {
        if($request->isMethod('post'))
        {
            $post = $request->all();
            $data = Manager::getList($post);
            return $data;
        }
        return view('admin.manager.index');
    }
模型部分
public static function getList(array $params)
    {
        //分页
        $offset = $params['start'];
        $limit = $params['length'];
        //排序
        $orderNameord = $params['order'][0]['column'];
        $orderName = $params['columns'][$orderNameord]['data'];
        $orderType = $params['order'][0]['dir'];
        //搜索参数
        //$search = $params['username'] ?? $params['search'];
        $search = $params['username'];
        $datemin = $params['datemin']??date('Y-m-d',strtotime('2018-8-1'));
        $datemax = $params['datemax'] ?date('Y-m-d 23:59:59',strtotime($params['datemax'])) : date('Y-m-d 23:59:59') ;
        $field = $params['field'] ?? 'username';
        $info = self::when($search,function($query)use($search){
            $query->where('username','like',"%$search%");
        })->whereBetween('created_at',[$datemin,$datemax])->orderBy($orderName,$orderType)->offset($offset)->limit($limit)->get();
        $count = self::count();
        $data = [
            'draw'=>$params['draw'],
            'recordsTotal'=>$count,
            'recordsFiltered'=>$count,
            'data'=>$info,
        ];
        return $data;

    }