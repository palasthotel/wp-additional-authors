import Search from "./Search";
import {useAdditionalAuthors, useMainAuthor} from "../hooks/use-post";
import Author from "./Author";

const Plugin = (props)=>{
    const {
        users,
        i18n,
    } = props;

    const mainAuthor = useMainAuthor();
    const [selected, setSelected] = useAdditionalAuthors();

    const onSelectSearchItem = (user)=>{
        const newSelection = [...new Set([...selected, user.ID])];
        setSelected(newSelection);
        document.dispatchEvent(
            new CustomEvent(
                "onAdditionalAuthorsChange",
                {
                    detail: newSelection.map( id=> users.find( u=> parseInt(u.ID) === parseInt(id) ) )
                }
            )
        );
    }

    const onChangePosition = (from, to) => {
        const userIdFrom = selected[from];
        const userIdTo = selected[to];
        const newSelection = [...selected]
        newSelection[from] = userIdTo;
        newSelection[to] = userIdFrom;
        setSelected(newSelection);
    }

    const onUnselect = (id)=>{
        setSelected(selected.filter(_id => parseInt(_id) !== parseInt(id)))
    }

    return <div style={{marginBottom: 20}}>

        <Search
            i18n={i18n}
            users={users.filter(u => {
                const notSelected = !selected.includes(u.ID+"") && !selected.includes( parseInt(u.ID));
                if(!notSelected) console.debug(u.ID, notSelected);
                return notSelected && parseInt(u.ID) !== parseInt(mainAuthor);
            })}
            onFound={onSelectSearchItem}
        />
        <div>
        {selected
            .filter(id => parseInt(mainAuthor) !== parseInt(id))
            .map((id, index)=>{
            return <Author
                key={id}
                author={users.find(u=> parseInt(u.ID) === parseInt(id))}
                index={index}
                onChangePosition={(to)=>onChangePosition(index, to)}
                onUnselect={()=>onUnselect(id)}
                isMainAuthor={false}
                />
        })}
        </div>
    </div>;
}

export default Plugin;