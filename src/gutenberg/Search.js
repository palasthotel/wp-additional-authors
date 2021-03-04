import {BaseControl, Popover, Spinner, TextControl} from "@wordpress/components";
import {useEffect, useState} from "@wordpress/element";
import { useEscapeKey } from "../hooks/use-utils.js";
import './Search.css'

const SearchResult = ({display_name, onClick})=>{
    return <div
        className="additional-authors-author"
        onClick={onClick}
    >
        {display_name}
    </div>
}

const Search = ({i18n, users, onFound})=>{

    const [state, setState] = useState("")
    const [isVisible, setIsVisible] = useState(false);
    const [results, setResults] = useState([]);

    useEffect(()=>{
        setResults(users.filter(u=>{
            return state === "" || u.display_name.includes(state);
        }));
    }, [state, users]);


    useEscapeKey(()=>{
        setIsVisible(false)
    }, [isVisible], isVisible)

    return <BaseControl className="additional-authors--search-author">
        <div className="additional-authors--search-authors__input-wrapper">
            <TextControl
                label={i18n.label}
                value={state}
                onChange={(value)=>{
                    setIsVisible(true)
                    setState(value);
                }}
                onFocus={()=>setIsVisible(true)}
            />
        </div>

        { isVisible ? (
            <Popover
                focusOnMount={false}
                position="bottom center"
            >
                {results.length > 0 ?
                    results.map(user=> <SearchResult
                            key={user.ID}
                            {...user}
                            onClick={()=>{
                                setIsVisible(false);
                                onFound(user);
                            }}
                        />
                    )
                    :
                    <p className="additional-authors--search-author__no-results">{i18n.search_404}</p>
                }

            </Popover>
        ) : null}
    </BaseControl>
}

export default Search