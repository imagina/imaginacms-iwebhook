<?php


namespace Modules\Iwebhooks\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;


class HookStatus extends Component
{

    public $id;
    public $params;
    public $classes;
    public $title;
    public $titleAlign;
    public $titleColor;
    public $titleColorClasses;
    public $titleSize;
    public $titleWeight;
    public $titleTransform;
    public $titleLetterSpacing;
    public $titleClasses;
    public $tableResponsive;
    public $tableSize;
    public $tableClasses;
    public $hooks;
    public $linkTarget;
    public $theadClasses;
    public $tbodyClasses;
    public $theadStyles;
    public $tbodyStyles;
    public $onlineLabelColor;
    public $offlineLabelColor;
    public $textLabelColor;
    public $colorLink;
    public $paging;
    public $ordering;
    public $searching;
    public $info;
    public $lengthChange;
    public $pagingType;
    public $datatables;
    public $columnDefs;
    public $lengthMenu;
    public $iconStyle;
    public $iconPosition;
    public $iconWidth;

    public function __construct($id = null,
                                $params = [],
                                $classes = null,
                                $title = "",
                                $titleAlign = "text-left",
                                $titleColor = null,
                                $titleColorClasses = 'text-primary',
                                $titleSize = null,
                                $titleWeight = "font-weight-normal",
                                $titleTransform = null,
                                $titleLetterSpacing = 0,
                                $titleClasses = "",
                                $tableResponsive = 'table-responsive',
                                $tableSize = '',
                                $tableClasses = '',
                                $linkTarget = "_blank",
                                $theadClasses = "",
                                $tbodyClasses = "",
                                $theadStyles = null,
                                $tbodyStyles = null,
                                $onlineLabelColor = '#28a745',
                                $offlineLabelColor = '#6c757d',
                                $textLabelColor = '#ffffff',
                                $colorLink = "#333333",
                                $paging = false,
                                $ordering = false,
                                $searching = false,
                                $info = false,
                                $lengthChange = false,
                                $pagingType = 'simple_numbers',
                                $datatables = false,
                                $columnDefs = null,
                                $lengthMenu = null,
                                $iconPosition = "left",
                                $iconWidth = "15px",
                                $iconStyle = null
    )
    {
        $this->id = $id ?? uniqid('hooks');
        $this->params = $params;
        $this->classes = $classes;
        $this->title = $title;
        $this->titleAlign = $titleAlign;
        $this->titleColor = $titleColor;
        $this->titleColorClasses = $titleColorClasses;
        $this->titleSize = $titleSize;
        $this->titleWeight = $titleWeight;
        $this->titleTransform = $titleTransform;
        $this->titleLetterSpacing = $titleLetterSpacing;
        $this->titleClasses = $titleClasses;
        $this->tableResponsive = $tableResponsive;
        $this->tableSize = $tableSize;
        $this->tableClasses = $tableClasses;
        $this->linkTarget = $linkTarget;
        $this->theadClasses = $theadClasses;
        $this->tbodyClasses = $tbodyClasses;
        $this->theadStyles = $theadStyles;
        $this->tbodyStyles = $tbodyStyles;
        $this->onlineLabelColor = $onlineLabelColor;
        $this->offlineLabelColor = $offlineLabelColor;
        $this->textLabelColor = $textLabelColor;
        $this->colorLink = $colorLink;
        $this->paging = $paging;
        $this->ordering = $ordering;
        $this->searching = $searching;
        $this->info = $info;
        $this->lengthChange = $lengthChange;
        $this->pagingType = $pagingType;
        $this->datatables = $datatables;
        $this->lengthMenu = json_encode($lengthMenu ?? [ [10, 25, 50, -1], [10, 25, 50, "All"] ]);
        $this->columnDefs = json_encode($columnDefs ?? [["width" => "auto", "targets" => "0"],["width" => "auto", "targets" => "1"],["width" => "auto", "targets" => "2"],["width" => "auto", "targets" => "3"]]);
        $this->iconStyle = $iconStyle;
        $this->iconPosition = $iconPosition;
        $this->iconWidth = $iconWidth;
        $this->getHooks();
    }

private
function makeParamsFunction()
{

    return [
        "include" => $this->params["include"] ?? ['lastLog', 'category', 'country'] ?? null,
        "take" => $this->params["take"] ?? false,
        "page" => $this->params["page"] ?? false,
        "filter" => $this->params["filter"] ?? [],
        "order" => $this->params["order"] ?? null
    ];
}

private
function getHooks()
{
    $repository = app('Modules\Iwebhooks\Repositories\HookRepository');
    $params = $this->makeParamsFunction();

    $this->hooks = $repository->getItemsBy(json_decode(json_encode($params)));


}

public
function render()
{
    return view("iwebhooks::frontend.components.hook-status");
}
}
