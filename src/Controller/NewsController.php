<?php

declare(strict_types=1);

namespace App\Controller;

use App\Auth;
use App\Database;
use App\Flash;
use App\ValueObject\NewsItem;
use App\ValueObject\DeletedNewsItem;

class NewsController extends Controller
{
    #[\Override]
    protected function before(): void
    {
        if (!Auth::check()) {
            $this->redirect('login');
        }
    }
    
    public function index(): void
    {
        $news = new Database()->fetchAll('SELECT * FROM news ORDER BY id ASC;');

        $this->render('news.html.twig', ['news' => $news]);
    }
    
    public function save(): void
    {
        try {
            $newsItem = new NewsItem($_POST);
            
            if ($newsItem->id > 0) {
                $updated = new Database()->updateById('news', [
                    'title' => $newsItem->title,
                    'description' => $newsItem->description,
                ], $newsItem->id);
                
                if ($updated > 0) {
                    Flash::set('News was successfully changed!', 'success');
                }
            } else {
                new Database()->insert('news', [
                    'title' => $newsItem->title,
                    'description' => $newsItem->description,
                ]);
                Flash::set('News was successfully created!', 'success');
            }
        } catch (\Exception $ex) {
            Flash::set($ex->getMessage(), 'error');
        } finally {
            $this->redirect('news');
        }
    }
    
    public function delete(): void
    {
        try {
            $deletedNewsItem = new DeletedNewsItem($_POST);
            
            $deleted = new Database()->delete('news', $deletedNewsItem->id);

            if ($deleted > 0) {
                Flash::set('News was deleted!', 'success');
            } else {
                throw new \Exception('News was not found!');
            }
        } catch (\Exception $ex) {
            Flash::set($ex->getMessage(), 'error');
        } finally {
            $this->redirect('news');
        }
    }
}
