import {useDispatch, useSelect} from '@wordpress/data';
import {useEffect} from "@wordpress/element";


export const usePost = ()=> useSelect(select => select("core/editor").getCurrentPost(), undefined);

export const useMainAuthor = ()=>{
    const author = useSelect(select => select("core/editor").getCurrentPost().author);
    const authorEdit = useSelect(select => select("core/editor").getPostEdits().author);
    return authorEdit || author;
}

export const useAdditionalAuthors = ()=>{

    const mainAuthor = useMainAuthor();
    const authors = useSelect(select => select("core/editor").getCurrentPost().additional_authors);
    const authorsEdited = useSelect(select => select("core/editor").getPostEdits().additional_authors);
    const {editPost} = useDispatch("core/editor");

    const additionalAuthors = (authorsEdited || authors).filter(id => parseInt(mainAuthor) !== parseInt(id));

    useEffect(()=>{
        if(additionalAuthors.includes(mainAuthor+"") || additionalAuthors.includes(parseInt(mainAuthor))){
            editPost(additionalAuthors.filter(id=> parseInt(id) !== parseInt(mainAuthor)));
        }
    }, [mainAuthor, additionalAuthors]);

    return [
        additionalAuthors,
        (userIds)=>{
            editPost({
                additional_authors: [mainAuthor, ...userIds],
            });
        }
    ]
}