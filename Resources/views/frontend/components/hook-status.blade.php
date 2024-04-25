<div id="{{$id}}" class="{{ $classes }} hooks-status">
    @if($title!=="")
    <div class="title-section {{$titleAlign}} {{$titleColorClasses}} {{$titleWeight}} {{$titleTransform}} {{$titleClasses}}">
      {{$title}}
    </div>
    @endif
    <div class="{{$tableResponsive}}">
        <table id="{{$id}}TableHookStatus" class="table {{$tableSize}} {{$tableClasses}}">
            <thead class="{{$theadClasses}}">
            <tr>
                <th scope="col">{{trans('iwebhooks::hooks.table.status')}}</th>
                <th scope="col">{{trans('iwebhooks::hooks.table.title')}}</th>
                <th scope="col">{{trans('iwebhooks::hooks.table.country')}}</th>
                <th scope="col">{{trans('iwebhooks::hooks.table.address')}}</th>
            </tr>
            </thead>
            <tbody class="{{$tbodyClasses}}">
            @foreach($hooks as $index => $hook)
            <tr>
                <td>
                    <span class="badge {{$hook->statusInfo->class}}">
                      {{$hook->statusInfo->label}}
                    </span>
                </td>
                <td>{{$hook->title ?? ''}}</td>
                <td>{{$hook->country->name ?? ''}}</td>
                <td>
                    @if($hook->redirect_link)
                    <a href="{{$hook->redirect_link}}" target="{{$linkTarget}}" class="link text-decoration-none">
                    @endif
                        {{$hook->mask_endpoint ?? $hook->hookInfo->hook ?? ''}}
                    @if($hook->redirect_link)
                    </a>

                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
#{{$id}} {
    & .title-section {
         @if($titleColorClasses=='text-custom') color: {{$titleColor}}; @endif
         font-size: {{$titleSize}}px;
    }
    & .badge.online {
        background-color: {{$onlineLabelColor}};
        color: {{$textLabelColor}};
    }
    & .badge.offline {
      background-color: {{$offlineLabelColor}};
      color: {{$textLabelColor}};
    }
    & .link {
        color: {{$colorLink}};
    }
    @if(!empty($theadStyles))
    & thead {
      {!! $theadStyles !!}
    }
    @endif
    @if(!empty($tbodyStyles))
    & tbody {
      {!! $tbodyStyles !!}
    }
    @endif
}
</style>
@if($datatables)
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap4.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.js"></script>
<script>
    $(document).ready(function() {
        $('#{{$id}}TableHookStatus').DataTable({
            language: {
                emptyTable: "{{trans('iwebhooks::hooks.datatables.emptyTable')}}",
                info: "{{trans('iwebhooks::hooks.datatables.info')}}",
                sSearch: "{{trans('iwebhooks::hooks.datatables.search')}}",
                sLengthMenu: "{{trans('iwebhooks::hooks.datatables.lengthMenu')}}",
                sZeroRecords: "{{trans('iwebhooks::hooks.datatables.zeroRecords')}}",
                sInfoEmpty: "{{trans('iwebhooks::hooks.datatables.infoEmpty')}}",
                sInfoFiltered: "{{trans('iwebhooks::hooks.datatables.infoFiltered')}}",
                oPaginate: {
                    sFirst: "{{trans('iwebhooks::hooks.datatables.paginate.first')}}",
                    sLast: "{{trans('iwebhooks::hooks.datatables.paginate.last')}}",
                    sNext: "{{trans('iwebhooks::hooks.datatables.paginate.next')}}",
                    sPrevious: "{{trans('iwebhooks::hooks.datatables.paginate.previous')}}"
                },
            },
            paging: {!! $paging ? 'true' : 'false' !!},
            ordering: {!! $ordering ? 'true' : 'false' !!},
            searching: {!! $searching ? 'true' : 'false' !!},
            info: {!! $info ? 'true' : 'false' !!},
            lengthChange: {!! $lengthChange ? 'true' : 'false' !!},
            pagingType: "{{$pagingType}}",
            lengthMenu: {!! $lengthMenu !!},
            columnDefs: {!! $columnDefs !!},
        });
    });
</script>
@endif