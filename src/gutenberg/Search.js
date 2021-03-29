import {BaseControl, Popover, Spinner, TextControl} from "@wordpress/components";
import {useEffect, useState, useRef} from "@wordpress/element";
import { useEscapeKey } from "../hooks/use-utils.js";
import './Search.css'
import useClickOutside from "use-click-outside";

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

    const ref = useRef();
    useClickOutside(ref, ()=>{
        setIsVisible(false);
    });

    useEffect(()=>{
        setResults(users.filter(u=>{
            return state === "" || u.display_name.toLowerCase().includes(state.toLowerCase());
        }));
    }, [state, users]);


    useEscapeKey(()=>{
        setIsVisible(false)
    }, [isVisible], isVisible)

    return <BaseControl className="additional-authors--search-author">
        <div ref={ref}>
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
        </div>
    </BaseControl>
}

export default Search