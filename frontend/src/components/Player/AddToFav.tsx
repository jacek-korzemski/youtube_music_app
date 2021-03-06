import { useState } from "react";
import { GoBackWrapper } from "./Wrappers";

const GoBack = () => {
  const [active, setActive] = useState(false);

  const activate = () => {
    setActive(!active);
  };

  return (
    <GoBackWrapper className={active ? "active" : "inactive"} onClick={() => activate()}>
      <i className="fi-heart"></i>
      <p>Favorite</p>
    </GoBackWrapper>
  );
};

export default GoBack;
