<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Schema for Huffington Post Article</title>
	</head>
	<header><h3>Relationships Between the Entities</h3></header>
	<body>
		<ul>
			<li>Huffington Post does not require a login to read their articles, so the Reader is not an actual entity
				for database purposes <em>until the Reader decides to "Like" or "Comment" on a page.</em></li>
			<li>An Article is an Entity with 6 attributes (ArticleID[pk], ArticleTitle, SectionID, Content, PublishDate, AuthorID)</li>
			<li>The Article is related to the Author via the ArticleID, an Entity with 1 attribute (AuthorID[pk])</li>
			<li>If a Reader reads & responds to the Article via the FaceBook Profile Entity, which has two attributes (FBuniqueID[pk], and Email) which are
				captured for logging "Likes" and "Comments".</li>
			<li>When the Reader "Likes" an article, an Entity called Likes is created, with 4 attributes (LikeID[pk], ArticleID, FBuniqueID, LikeDate)</li>
			<li>When the Reader "Comments" on at article, an Entity called Comments is created, with 5 attributes (ParentCommentID[pk], ParentCommentContent,
			ArticleID, ParentCommentDate, FBuniqueID)</li>
			<li>When the Reader makes a comment on a comment, a reiterative loop is goes back to Comment.</li>
			<li>When the Reader "Likes" a comment, an Entity called CommentLikes is created, with 4 attributes (CommentLikeID[pk], ParentCommentID,
			FBuniquID, CommentLikeDate)</li>
			<li>The reason the FBuniqueID is included in several spots is because a new Reader can choose to "Like a Comment" or "Comment on
				a Comment" as their first interaction with the article.</li>
		</ul>
		<p>
			<img src="huffpost_comment_ERD.svg" alt="Here is the Huffington Post Comment ERD"/>
		</p>
	</body>
</html>