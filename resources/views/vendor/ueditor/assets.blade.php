<!-- 配置文件 -->
<script type="text/javascript" src="{{ asset('vendor/ueditor/ueditor.config.js') }}"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="{{ asset('vendor/ueditor/ueditor.all.js') }}"></script>
<script>
    $('.editor').each(function() {
        this.editor = UE.getEditor($(this).attr('id'), $.extend(window.UEDITOR_CONFIG, {
            serverUrl: '/api/common/ueditor_upload',
            initialContent: '',
            serverparam: {
                '_token': $('meta[name="csrf-token"]').attr('content') || '',
            },
            contextMenu: [],
            autoClearinitialContent: false,
            wordCount: false,
            removeFormatTags:'a,b,big,code,del,dfn,em,font,i,section,blockquote,pre,fieldset,ins,kbd,q,samp,small,span,label,strike,strong,sub,sup,tt,u,var',
            removeFormatAttributes:'class,style,lang,width,accuse,height,align,hspace,valign,data-width,data-brushtype,opacity,border,title,placeholder',
            autoHeightEnabled: false,
            indentValue: '0em',
            autoClearEmptyNode: true,
            allowDivTransToP: false,
            initialFrameWidth: '100%',
            initialFrameHeight: $(this).outerHeight() || ($(this).attr('rows') * parseInt(window.getComputedStyle(this)['line-height'])) || 400,
            initialStyle: 'body{font-size:14px; }',
            minFrameHeight: 400,
            scaleEnabled: false,
            imageScaleEnabled: false,
            allHtmlEnabled: false,
            elementPathEnabled: false,
            catchRemoteImageEnable: false,

            zIndex: 1,
            listDefaultPaddingLeft: '30',
            maxListLevel: -1,
            enableContextMenu:true,
            autotypeset: {
                mergeEmptyline: true,           //合并空行
                removeClass: false,              //去掉冗余的class
                removeEmptyline: false,         //去掉空行
                textAlign:false,
                //textAlign:"left",               //段落的排版方式，可以是 left,right,center,justify 去掉这个属性表示不执行排版
                imageBlockLine: false,       //图片的浮动方式，独占一行剧中,左右浮动，默认: center,left,right,none 去掉这个属性表示不执行排版
                pasteFilter: false,             //根据规则过滤没事粘贴进来的内容
                clearFontSize: false,           //去掉所有的内嵌字号，使用编辑器默认的字号
                clearFontFamily: false,         //去掉所有的内嵌字体，使用编辑器默认的字体
                removeEmptyNode: false,         // 去掉空节点
                //可以去掉的标签
                //removeTagNames: {标签名字:1},
                indent: false,                  // 行首缩进
                indentValue : '2em',            //行首缩进的大小
                bdc2sb: false,
                tobdc: false,
            },
            disabledTableInTable: true,
            tableDragable: true,
            fontfamily:[
                { label:'',name:'yahei',val:'微软雅黑'}, // 微软雅黑,Microsoft YaHei
                { label:'',name:'songti',val:'宋体,SimSun'},
                { label:'',name:'kaiti',val:'楷体,楷体_GB2312,SimKai'},
                { label:'',name:'heiti',val:'黑体,SimHei'},
                { label:'',name:'lishu',val:'隶书,SimLi'},
                { label:'',name:'arial',val:'arial,helvetica,sans-serif'}
            ],
            fontsize:[10,11,12,13,14,15,16,17,18,19,20,24,28,32,36],
            autoTransWordToList: true,
            insertorderedlist:{
                'decimal' : '' ,         //'1,2,3...'
                'lower-alpha' : '' ,    // 'a,b,c...'
                'lower-roman' : '' ,    //'i,ii,iii...'
                'upper-alpha' : '' , //lang   //'A,B,C'
                'upper-roman' : '' ,     //'I,II,III...'
                'cjk-ideographic' : '一、二、三、',
                'lower-greek':'α,β,γ,δ'
            },
            insertunorderedlist:{
                'circle' : '',  // '○ 小圆圈'
                'disc' : '',    // '● 小圆点'
                'square' : ''   //'■ 小方块'
            },
            toolbars: [
                ['source', 'fullscreen', 'undo', 'redo', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'justifyleft', 'justifycenter', 'justifyright', '|', 'insertorderedlist', 'insertunorderedlist', '|', 'link', 'unlink', '|','simpleupload', 'insertimage', 'insertvideo', 'map', 'wordimage', '|', 'horizontal', 'spechars', 'removeformat', '|', 'searchreplace', '|', 'preview']
            ],
            retainOnlyLabelPasted: false,
            pasteplain:false,
        }));
    });
</script>
