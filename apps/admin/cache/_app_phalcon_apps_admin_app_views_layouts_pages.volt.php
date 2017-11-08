<div class="footer">
    <div class="col-sm-6 text-left">当前第<?php echo $pages->current; ?>页，共 <?php echo $pages->total_pages; ?> 页</div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li class="paginate_button previous"><a href="<?php echo $this->url->get($this->request->get('_url'), \Base::pageurl(['page' => 1]))?>">首页</a></li>
            <li class="paginate_button previous"><a href="<?php echo $this->url->get($this->request->get('_url'), \Base::pageurl(['page' => $pages->before]))?>">上一页</a></li>
            <li class="paginate_button next"><a href="<?php echo $this->url->get($this->request->get('_url'), \Base::pageurl(['page' => $pages->next]))?>">下一页</a></li>
            <li class="paginate_button next"><a href="<?php echo $this->url->get($this->request->get('_url'), \Base::pageurl(['page' => $pages->last]))?>">尾页</a></li>
        </ul>
    </div>
</div>